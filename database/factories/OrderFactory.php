<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([
            'pending', 'processing', 'completed', 'cancelled',
        ]);

        // Default random total (will be updated by Seeder)
        $total = $this->faker->randomFloat(2, 50, 5000);

        // Tax (5%)
        $tax = round($total * 0.05, 2);

        // Discount only for completed
        $discount = $this->faker->boolean(30)
            ? round($total * $this->faker->randomFloat(2, 0.05, 0.20), 2)
            : 0;

        if (in_array($status, ['pending', 'processing'])) {
            $discount = 0;
        }

        $completedAt = $status === 'completed'
            ? now()->subDays(rand(1, 60))
            : null;

        if ($status === 'cancelled') {
            $total = 0;
            $tax = 0;
            $discount = 0;
            $completedAt = null;
        }

        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-'.strtoupper(Str::uuid()->toString()),
            'total_amount' => $total,
            'tax_amount' => $tax,
            'discount_amount' => $discount,
            'status' => $status,
            'completed_at' => $completedAt,
        ];
    }

    public function completed()
    {
        return $this->state(fn () => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function pending()
    {
        return $this->state(fn () => [
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    public function cancelled()
    {
        return $this->state(fn () => [
            'status' => 'cancelled',
            'completed_at' => null,
        ]);
    }
}
