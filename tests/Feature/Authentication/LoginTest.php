<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Domain\User\Models\User;

class LoginTest extends TestCase
{
    /**
     * @group auth
     */
    public function test_can_login(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        $response = $this->postJson(
            route('auth.login'),
            [
                'email' => $user->email,
                'password' => 'defaultpassword'
            ]
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'access_token',
                'token_type',
                'expires_at'
            ]
        ]);
        
        $this->assertNotEmpty($response['data']['access_token']);
        $this->assertNotEmpty($response['data']['token_type']);
        $this->assertNotEmpty($response['data']['expires_at']);
        $this->assertEquals('Bearer', $response['data']['token_type']);
    }

    /**
     * @group auth
     */
    public function test_cannot_login_with_nonexistent_user(): void
    {
        $response = $this->postJson(
            route('auth.login'),
            [
                'email' => 'nonexistentemail@test.com',
                'password' => 'nonexistentpassword'
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson(['message' => 'Could not found a valid user with the email: nonexistentemail@test.com.']);
    }

    /**
     * @group auth
     */
    public function test_cannot_login_with_incorrect_password(): void
    {
        $user = User::factory()->create([
            'password' => 'defaultpassword'
        ]);

        $response = $this->postJson(
            route('auth.login'),
            [
                'email' => $user->email,
                'password' => 'wrong_password'
            ]
        );

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson(['message' => 'The password provided for this user is incorrect.']);
    }
}
