<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
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
        ]);
    }

    public function process(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => ['required', 'string', 'in:mpesa,card'],
            'phone_number' => ['required_if:payment_method,mpesa', 'string', 'regex:/^254[0-9]{9}$/'],
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

            // TODO: Initiate M-Pesa payment or card payment
            if ($validated['payment_method'] === 'mpesa') {
                // For now, simulate successful payment
                // In production, this would call M-Pesa STK Push API
                $order->update([
                    'status' => 'paid',
                    'payment_status' => 'completed',
                    'payment_reference' => 'MPESA-'.strtoupper(uniqid()),
                    'paid_at' => now(),
                ]);

                // Create enrollments
                foreach ($cartItems as $cartItem) {
                    Enrollment::create([
                        'user_id' => auth()->id(),
                        'course_id' => $cartItem->course_id,
                        'enrollment_status' => 'active',
                        'enrolled_at' => now(),
                        'price_paid' => $cartItem->final_price,
                    ]);
                }

                // Clear cart
                Cart::where('user_id', auth()->id())->delete();

                DB::commit();

                return redirect()
                    ->route('checkout.success', ['order' => $order->order_number])
                    ->with('success', 'Payment successful! You are now enrolled in the courses.');
            }

            // Card payment not yet implemented
            DB::rollBack();

            return redirect()
                ->route('checkout.index')
                ->with('error', 'Card payment is coming soon. Please use M-Pesa.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('checkout.index')
                ->with('error', 'Payment failed. Please try again.');
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
