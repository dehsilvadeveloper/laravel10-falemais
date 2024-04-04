<?php

namespace Tests\Unit\App\Http\Controllers;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use App\Domain\Auth\DataTransferObjects\LoginDto;
use App\Domain\Auth\DataTransferObjects\SuccessfulAuthDto;
use App\Domain\Auth\Services\Interfaces\AuthServiceInterface;
use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\Api\LoginRequest;

class AuthControllerTest extends TestCase
{
    /** @var AuthController */
    private $controller;

    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serviceMock = Mockery::mock(AuthServiceInterface::class);
        $this->controller = new AuthController($this->serviceMock);
    }

    /**
     * @group controllers
     * @group auth
     */
    public function test_can_login(): void
    {
        Mail::fake();
        Event::fake();
        Notification::fake();
        Queue::fake();

        $requestData = [
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password()
        ];
        $request = LoginRequest::create('/auth/login', 'POST', $requestData);

        $successfulAuthDto = SuccessfulAuthDto::from([
            'access_token' => '1|laravel10_falemaisU93B9se52Ww1L7fNiKRkC2p154ywSAdtEyNNSX8ca6e24993',
            'token_type' => 'Bearer',
            'expires_at' => now()->format('Y-m-d H:i:s')
        ]);

        $this->serviceMock
            ->shouldReceive('login')
            ->once()
            ->with(Mockery::type(LoginDto::class))
            /*
            # Another Option:
            ->withArgs(function ($loginDto) use($requestData) {
                static::assertNotNull($loginDto);
                static::assertSame($requestData['email'], $loginDto->email);
                static::assertSame($requestData['password'], $loginDto->password);
                return true;
            })
            */
            ->andReturn($successfulAuthDto);

        $response = $this->controller->login($request);
        $responseAsArray = $response->getData(true);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($responseAsArray['data']['access_token'], $successfulAuthDto->accessToken);
        $this->assertEquals($responseAsArray['data']['token_type'], $successfulAuthDto->tokenType);
        $this->assertEquals($responseAsArray['data']['expires_at'], $successfulAuthDto->expiresAt);
    }

    /**
     * @group controllers
     * @group auth
     */
    public function test_generates_log_if_cannot_login(): void
    {
        Mail::fake();
        Event::fake();
        Notification::fake();
        Queue::fake();

        $requestData = [
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password()
        ];
        $request = LoginRequest::create('/auth/login', 'POST', $requestData);

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[AuthController] Failed to login with the credentials provided.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->serviceMock
            ->shouldReceive('login')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.', Response::HTTP_BAD_REQUEST));

        $response = $this->controller->login($request);
        $responseAsArray = $response->getData(true);

        $this->assertEquals(
            'An error has occurred. Could not login with the credentials provided as requested.',
            $responseAsArray['message']
        );
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
