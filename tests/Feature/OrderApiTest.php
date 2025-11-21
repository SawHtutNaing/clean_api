<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    /** @test */
    public function it_can_list_orders_with_pagination()
    {
        Order::factory()->count(20)->create(['user_id' => $this->user->id]);

        $response = $this->withToken($this->token)
            ->getJson('/api/v1/orders?per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'order_number',
                        'total_amount',
                        'status',
                    ],
                ],
                'meta' => [
                    'total',
                    'per_page',
                    'current_page',
                ],
            ]);
    }

    /** @test */
    public function it_can_filter_orders_by_status()
    {
        Order::factory()->create(['user_id' => $this->user->id, 'status' => 'pending']);
        Order::factory()->create(['user_id' => $this->user->id, 'status' => 'completed']);

        $response = $this->withToken($this->token)
            ->getJson('/api/v1/orders?status=completed');

        $response->assertStatus(200);
        $this->assertEquals(1, count($response->json('data')));
    }

    /** @test */
    public function it_can_create_order_with_items()
    {
        $product = Product::factory()->create(['price' => 100, 'stock' => 10]);

        $orderData = [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->withToken($this->token)
            ->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'order_number',
                    'items',
                ],
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
        ]);

        $product->refresh();
        $this->assertEquals(8, $product->stock);
    }

    /** @test */
    public function it_validates_insufficient_stock()
    {
        $product = Product::factory()->create(['stock' => 1]);

        $orderData = [
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5,
                ],
            ],
        ];

        $response = $this->withToken($this->token)
            ->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_requires_authentication()
    {
        $response = $this->getJson('/api/v1/orders');
        $response->assertStatus(401);
    }
}
