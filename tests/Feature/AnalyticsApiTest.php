<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnalyticsApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_dashboard_analytics()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        Order::factory()->count(10)->create([
            'status' => 'completed',
            'total_amount' => 100,
        ]);

        $response = $this->withToken($token)
            ->getJson('/api/analytics/dashboard');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total_sales',
                'monthly_chart',
                'daily_breakdown',
                'top_products',
                'summary',
            ]);
    }
}
