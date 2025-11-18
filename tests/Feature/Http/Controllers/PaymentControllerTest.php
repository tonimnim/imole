<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\HandlePaystackWebhook;
use App\Jobs\InitializePaystackPayment;
use App\Jobs\VerifyPaystackPayment;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentController
 */
final class PaymentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'store',
            \App\Http\Requests\PaymentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_responds_with(): void
    {
        $course = Course::factory()->create();
        $amount = fake()->randomFloat(/** decimal_attributes **/);
        $customer_email = fake()->word();

        Queue::fake();

        $response = $this->post(route('payments.store'), [
            'course_id' => $course->id,
            'amount' => $amount,
            'customer_email' => $customer_email,
        ]);

        $payments = Payment::query()
            ->where('course_id', $course->id)
            ->where('amount', $amount)
            ->where('customer_email', $customer_email)
            ->get();
        $this->assertCount(1, $payments);
        $payment = $payments->first();

        $response->assertOk();
        $response->assertJson($payment, 201);

        Queue::assertPushed(InitializePaystackPayment::class, function ($job) use ($payment) {
            return $job->payment->is($payment);
        });
    }


    #[Test]
    public function show_displays_view(): void
    {
        $payment = Payment::factory()->create();

        $response = $this->get(route('payments.show', $payment));

        $response->assertOk();
        $response->assertViewIs('payment.show');
        $response->assertViewHas('payment');
    }


    #[Test]
    public function verify_responds_with(): void
    {
        $payment = Payment::factory()->create();

        Queue::fake();

        $response = $this->get(route('payments.verify'));

        $response->assertOk();
        $response->assertJson($payment, 200);

        Queue::assertPushed(VerifyPaystackPayment::class, function ($job) use ($payment) {
            return $job->payment->is($payment);
        });
    }


    #[Test]
    public function webhook_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PaymentController::class,
            'webhook',
            \App\Http\Requests\PaymentWebhookRequest::class
        );
    }

    #[Test]
    public function webhook_responds_with(): void
    {
        $paystack_reference = fake()->word();

        Queue::fake();

        $response = $this->get(route('payments.webhook'), [
            'paystack_reference' => $paystack_reference,
        ]);

        $response->assertOk();

        Queue::assertPushed(HandlePaystackWebhook::class);
    }
}
