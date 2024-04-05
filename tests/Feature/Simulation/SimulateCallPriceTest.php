<?php

namespace Tests\Feature\Simulation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use App\Domain\User\Models\User;
use Database\Seeders\FareSeeder;
use Database\Seeders\PlanSeeder;

class SimulateCallPriceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(FareSeeder::class);
        $this->seed(PlanSeeder::class);
    }

    /**
     * @group simulation
     */
    public function test_can_simulate(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson(
            route('call-price.simulate'),
            [
                'ddd_origin' => '011',
                'ddd_destination' => '017',
                'call_minutes' => 80,
                'plan_id' => 2
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'price_with_plan',
                'price_without_plan'
            ]
        ]);

        $this->assertNotEmpty($response['data']['price_with_plan']);
        $this->assertNotEmpty($response['data']['price_without_plan']);
        $this->assertEqualsWithDelta(37.40, $response['data']['price_with_plan'], 0.0001);
        $this->assertEqualsWithDelta(136, $response['data']['price_without_plan'], 0.0001);
    }

    /**
     * @group simulation
     */
    public function test_cannot_simulate_with_nonexistent_fare(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson(
            route('call-price.simulate'),
            [
                'ddd_origin' => '998',
                'ddd_destination' => '999',
                'call_minutes' => 80,
                'plan_id' => 2
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson([
            'message' => 'Cannot proceed. Could no find a fare with the ddd origin and ddd destination provided.'
        ]);
    }

    /**
     * @group simulation
     */
    public function test_cannot_simulate_with_nonexistent_plan(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson(
            route('call-price.simulate'),
            [
                'ddd_origin' => '011',
                'ddd_destination' => '017',
                'call_minutes' => 80,
                'plan_id' => 999
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertValid(['ddd_origin', 'ddd_destination', 'call_minutes']);
        $response->assertInvalid([
            'plan_id' => 'The selected plan id is invalid.'
        ]);
    }

    /**
     * @group simulation
     */
    public function test_cannot_simulate_without_call_minutes(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson(
            route('call-price.simulate'),
            [
                'ddd_origin' => '011',
                'ddd_destination' => '017',
                'plan_id' => 2
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertValid(['ddd_origin', 'ddd_destination', 'plan_id']);
        $response->assertInvalid([
            'call_minutes' => 'The call minutes field is required.'
        ]);
    }
}
