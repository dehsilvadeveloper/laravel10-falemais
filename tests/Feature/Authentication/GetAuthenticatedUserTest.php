<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use App\Domain\User\Models\User;

class GetAuthenticatedUserTest extends TestCase
{
    /**
     * @group auth
     */
    public function test_can_get_authenticated_user_data(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('auth.me'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at'
        ]);
        $response->assertJsonMissing(['password']);

        $this->assertNotEmpty($response['id']);
        $this->assertNotEmpty($response['name']);
        $this->assertNotEmpty($response['email']);
        $this->assertEquals($user->id, $response['id']);
        $this->assertEquals($user->name, $response['name']);
        $this->assertEquals($user->email, $response['email']);
    }

    /**
     * @group auth
     */
    public function test_cannot_get_data_of_unauthenticated_user(): void
    {
        $response = $this->getJson(route('auth.me'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertExactJson(['message' => 'Unauthenticated.']);
    }
}
