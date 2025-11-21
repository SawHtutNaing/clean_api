<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['payment', 'refund', 'adjustment']);
        $status = fake()->randomElement(['pending', 'processing', 'completed', 'failed', 'cancelled']);
        $paymentMethod = fake()->randomElement(['credit_card', 'debit_card', 'paypal', 'bank_transfer', 'cash']);

        $gateway = in_array($paymentMethod, ['credit_card', 'debit_card', 'paypal'])
            ? fake()->randomElement(['stripe', 'paypal', 'square'])
            : null;

        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'transaction_number' => 'TXN-' . strtoupper(uniqid()),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'type' => $type,
            'payment_method' => $paymentMethod,
            'status' => $status,
            'payment_gateway' => $gateway,
            'gateway_transaction_id' => $gateway ? 'ch_' . uniqid() : null,
            'gateway_response' => json_encode([
                'status' => $status,
                'message' => 'Transaction ' . $status,
            ]),
            'notes' => fake()->optional()->sentence(),
            'processed_at' => $status === 'completed' ? fake()->dateTimeThisMonth() : null,
            'failed_at' => $status === 'failed' ? fake()->dateTimeThisMonth() : null,
            'refunded_at' => $status === 'refunded' ? fake()->dateTimeThisMonth() : null,
        ];
    }

    /**
     * Indicate that the transaction is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'processed_at' => fake()->dateTimeThisMonth(),
        ]);
    }

    /**
     * Indicate that the transaction is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'processed_at' => null,
            'gateway_transaction_id' => null,
        ]);
    }

    /**
     * Indicate that the transaction has failed.
     */
    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
            'failed_at' => fake()->dateTimeThisMonth(),
            'gateway_transaction_id' => null,
            'gateway_response' => json_encode([
                'status' => 'failed',
                'message' => fake()->randomElement([
                    'Insufficient funds',
                    'Card declined',
                    'Payment gateway timeout',
                ]),
            ]),
        ]);
    }

    /**
     * Indicate that the transaction is a refund.
     */
    public function refund(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'refund',
            'status' => 'completed',
            'refunded_at' => fake()->dateTimeThisMonth(),
        ]);
    }
}
