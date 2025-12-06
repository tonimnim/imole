<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentWebhookRequest;
use App\Jobs\HandlePaystackWebhook;
use App\Jobs\InitializePaystackPayment;
use App\Jobs\VerifyPaystackPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function store(PaymentStoreRequest $request)
    {
        $payment = Payment::create($request->validated());

        InitializePaystackPayment::dispatch($payment);

        return response()->json($payment, 201);
    }

    public function show(Request $request, Payment $payment): View
    {
        return view('payment.show', [
            'payment' => $payment,
        ]);
    }

    public function verify(Request $request, string $paystack_reference)
    {
        $payment = Payment::where('paystack_reference', $paystack_reference)->firstOrFail();

        VerifyPaystackPayment::dispatch($payment);

        return response()->json($payment, 200);
    }

    public function webhook(PaymentWebhookRequest $request): Response
    {
        HandlePaystackWebhook::dispatch();

        return response()->noContent(200);
    }
}
