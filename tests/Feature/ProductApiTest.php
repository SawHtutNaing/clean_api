<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
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
    public function it_can_list_products_with_pagination()
    {
        Product::factory()->count(20)->create();

        $response = $this->withToken($this->token)
            ->getJson('/api/products?per_page=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['*' => ['id', 'name', 'price']],
                'meta' => ['total', 'per_page', 'current_page'],
            ]);
    }

    /** @test */
    public function it_can_create_product()
    {
        $productData = [
            'name' => 'Test Product',
            'price' => 99.99,
            'stock' => 10,
        ];

        $response = $this->withToken($this->token)
            ->postJson('/api/products', $productData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_requires_authentication_for_products()
    {
        $response = $this->getJson('/api/products');
        $response->assertStatus(401);
    }
}
