<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        foreach ($users as $user) {

            // Create order with factory logic (status, tax, discount, etc)
            $order = Order::factory()->create([
                'user_id' => $user->id,
            ]);

            $itemsCount = fake()->numberBetween(1, 5);
            $total = 0;

            for ($i = 0; $i < $itemsCount; $i++) {

                $product = $products->random();
                $quantity = fake()->numberBetween(1, min(10, $product->stock));
                $unitPrice = $product->price;
                $subtotal = $quantity * $unitPrice;

                OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Update final real totals
            $order->update([
                'total_amount' => $total,
                'tax_amount' => round($total * 0.05, 2),
                'discount_amount' => fake()->boolean(30)
                    ? round($total * fake()->randomFloat(2, 0.05, 0.2), 2)
                    : 0,
            ]);
        }
    }
}
