<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use App\Domain\User\Models\User;

class RoutesProtectionTest extends TestCase
{
    /**
     * @group auth
     */
    public function test_can_access_protected_route_if_authenticated(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('plan.list'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @group auth
     */
    public function test_cannot_access_protected_route_if_not_authenticated(): void
    {
        $response = $this->getJson(route('plan.list'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }
}
