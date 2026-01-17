<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected PaystackService $paystack
    ) {}

    public function index(): View|RedirectResponse
    {
        $cartItems = Cart::query()
            ->where('user_id', auth()->id())
            ->with(['course' => function ($query) {
                $query->with(['instructor', 'category']);
            }])
            ->get();

        // Redirect if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum('final_price');
        $tax = 0; // Add tax calculation if needed
        $total = $subtotal + $tax;

        return view('checkout.index', [
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'paystackPublicKey' => $this->paystack->getPublicKey(),
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:mpesa,card'],
            'phone_number' => ['required_if:payment_method,mpesa', 'nullable', 'string', 'regex:/^254[0-9]{9}$/'],
        ]);

        // Get cart items
        $cartItems = Cart::query()
            ->where('user_id', auth()->id())
            ->with('course')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum('final_price');
        $tax = 0;
        $total = $subtotal + $tax;

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'course_id' => $cartItem->course_id,
                    'price' => $cartItem->price,
                    'discount_price' => $cartItem->discount_price,
                ]);
            }

            DB::commit();

            // Handle payment based on method
            if ($validated['payment_method'] === 'mpesa') {
                return $this->processMpesaPayment($order, $validated['phone_number']);
            }

            // Card payment via Paystack
            return $this->processPaystackPayment($order);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout processing error', ['error' => $e->getMessage()]);

            return redirect()
                ->route('checkout.index')
                ->with('error', 'Payment failed. Please try again.');
        }
    }

    protected function processMpesaPayment(Order $order, string $phoneNumber): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // For now, simulate successful payment
            // In production, this would call M-Pesa STK Push API
            $order->update([
                'status' => 'paid',
                'payment_status' => 'completed',
                'payment_reference' => 'MPESA-'.strtoupper(uniqid()),
                'paid_at' => now(),
            ]);

            // Create payment record
            Payment::create([
                'user_id' => $order->user_id,
                'reference' => $order->payment_reference,
                'amount' => $order->total,
                'currency' => 'KES',
                'status' => 'completed',
                'payment_method' => 'mpesa',
                'metadata' => [
                    'order_id' => $order->id,
                    'phone_number' => $phoneNumber,
                ],
            ]);

            // Create enrollments
            $this->createEnrollments($order);

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()
                ->route('checkout.success', ['order' => $order->order_number])
                ->with('success', 'Payment successful! You are now enrolled in the courses.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('M-Pesa payment error', ['error' => $e->getMessage()]);

            return redirect()
                ->route('checkout.failed', ['order' => $order->order_number])
                ->with('error', 'Payment failed. Please try again.');
        }
    }

    protected function processPaystackPayment(Order $order): RedirectResponse
    {
        $user = auth()->user();
        $reference = $this->paystack->generateReference();

        // Update order with payment reference
        $order->update(['payment_reference' => $reference]);

        // Initialize Paystack transaction
        $response = $this->paystack->initializeTransaction([
            'email' => $user->email,
            'amount' => (int) $order->total,
            'reference' => $reference,
            'callback_url' => route('paystack.callback'),
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $user->id,
            ],
        ]);

        if (! $response['status']) {
            Log::error('Paystack initialization failed', ['response' => $response]);

            return redirect()
                ->route('checkout.index')
                ->with('error', $response['message'] ?? 'Failed to initialize payment. Please try again.');
        }

        // Redirect to Paystack payment page
        return redirect()->away($response['data']['authorization_url']);
    }

    public function paystackCallback(Request $request): RedirectResponse
    {
        $reference = $request->query('reference');

        if (! $reference) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Invalid payment reference.');
        }

        // Verify the transaction
        $response = $this->paystack->verifyTransaction($reference);

        if (! $response['status']) {
            Log::error('Paystack verification failed', ['reference' => $reference, 'response' => $response]);

            // Find the order and redirect to failed page
            $order = Order::where('payment_reference', $reference)->first();
            if ($order) {
                $order->update(['payment_status' => 'failed']);

                return redirect()
                    ->route('checkout.failed', ['order' => $order->order_number])
                    ->with('error', 'Payment verification failed. Please contact support.');
            }

            return redirect()
                ->route('cart.index')
                ->with('error', 'Payment verification failed.');
        }

        try {
            DB::beginTransaction();

            $order = Order::where('payment_reference', $reference)->firstOrFail();

            // Update order status
            $order->update([
                'status' => 'paid',
                'payment_status' => 'completed',
                'paid_at' => now(),
            ]);

            // Create payment record
            Payment::create([
                'user_id' => $order->user_id,
                'reference' => $reference,
                'amount' => $order->total,
                'currency' => 'KES',
                'status' => 'completed',
                'payment_method' => 'card',
                'metadata' => [
                    'order_id' => $order->id,
                    'paystack_response' => $response['data'],
                ],
            ]);

            // Create enrollments
            $this->createEnrollments($order);

            // Clear cart
            Cart::where('user_id', $order->user_id)->delete();

            DB::commit();

            return redirect()
                ->route('checkout.success', ['order' => $order->order_number])
                ->with('success', 'Payment successful! You are now enrolled in the courses.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Paystack callback processing error', [
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('cart.index')
                ->with('error', 'An error occurred while processing your payment. Please contact support.');
        }
    }

    public function paystackWebhook(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate webhook signature
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (! $this->paystack->validateWebhookSignature($payload, $signature)) {
            Log::warning('Invalid Paystack webhook signature');

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $request->all();

        // Handle different event types
        if ($event['event'] === 'charge.success') {
            $data = $event['data'];
            $reference = $data['reference'];

            $order = Order::where('payment_reference', $reference)
                ->where('payment_status', 'pending')
                ->first();

            if ($order) {
                try {
                    DB::beginTransaction();

                    $order->update([
                        'status' => 'paid',
                        'payment_status' => 'completed',
                        'paid_at' => now(),
                    ]);

                    // Create payment record if not exists
                    Payment::firstOrCreate(
                        ['reference' => $reference],
                        [
                            'user_id' => $order->user_id,
                            'amount' => $order->total,
                            'currency' => 'KES',
                            'status' => 'completed',
                            'payment_method' => 'card',
                            'metadata' => [
                                'order_id' => $order->id,
                                'webhook_data' => $data,
                            ],
                        ]
                    );

                    // Create enrollments
                    $this->createEnrollments($order);

                    // Clear cart
                    Cart::where('user_id', $order->user_id)->delete();

                    DB::commit();

                    Log::info('Paystack webhook processed successfully', ['reference' => $reference]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Paystack webhook processing error', [
                        'reference' => $reference,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    protected function createEnrollments(Order $order): void
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $item) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $order->user_id,
                    'course_id' => $item->course_id,
                ],
                [
                    'enrollment_status' => 'active',
                    'enrolled_at' => now(),
                    'price_paid' => $item->discount_price ?? $item->price,
                ]
            );
        }
    }

    public function success(Request $request, string $orderNumber): View
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.course'])
            ->firstOrFail();

        return view('checkout.success', ['order' => $order]);
    }

    public function failed(Request $request, string $orderNumber): View
    {
        $order = Order::query()
            ->where('order_number', $orderNumber)
            ->where('user_id', auth()->id())
            ->with(['items.course'])
            ->firstOrFail();

        return view('checkout.failed', ['order' => $order]);
    }
}
