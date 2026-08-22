<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'course_id' => Course::factory(),
            'reference' => fake()->uuid(),
            'amount' => fake()->randomFloat(2, 100, 10000),
            'currency' => 'NGN',
            'status' => fake()->randomElement(['pending', 'success', 'failed']),
            'payment_method' => 'paystack',
            'metadata' => [],
            'paid_at' => null,
        ];
    }

    public function success(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'success',
            'paid_at' => now(),
        ]);
    }
}
