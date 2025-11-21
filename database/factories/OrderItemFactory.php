<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();

        // Safe fallback if no products exist
        if (! $product) {
            return [
                'order_id' => Order::factory(),
                'product_id' => null,
                'quantity' => 1,
                'unit_price' => 0,
                'subtotal' => 0,
            ];
        }

        $quantity = $this->faker->numberBetween(1, min(10, $product->stock));
        $unitPrice = $product->price;
        $subtotal = $quantity * $unitPrice;

        return [
            'order_id' => Order::factory(), // will be overridden in seeder
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
        ];
    }
}
