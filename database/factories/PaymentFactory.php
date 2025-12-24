<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'amount' => fake()->randomFloat(2, 0, 99999999.99),
            'currency' => fake()->regexify('[A-Za-z0-9]{3}'),
            'payment_method' => fake()->randomElement(['card', 'bank', 'ussd', 'mobile_money', 'qr']),
            'paystack_reference' => fake()->regexify('[A-Za-z0-9]{255}'),
            'paystack_access_code' => fake()->regexify('[A-Za-z0-9]{255}'),
            'paystack_authorization_code' => fake()->regexify('[A-Za-z0-9]{255}'),
            'transaction_id' => fake()->regexify('[A-Za-z0-9]{255}'),
            'reference_code' => fake()->regexify('[A-Za-z0-9]{100}'),
            'gateway_response' => fake()->regexify('[A-Za-z0-9]{255}'),
            'channel' => fake()->regexify('[A-Za-z0-9]{50}'),
            'ip_address' => fake()->regexify('[A-Za-z0-9]{45}'),
            'status' => fake()->randomElement(['pending', 'success', 'failed', 'abandoned', 'refunded']),
            'paid_at' => fake()->dateTime(),
            'customer_email' => fake()->regexify('[A-Za-z0-9]{255}'),
            'customer_code' => fake()->regexify('[A-Za-z0-9]{100}'),
            'metadata' => '{}',
        ];
    }
}
