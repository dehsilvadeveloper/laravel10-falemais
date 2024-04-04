<?php

namespace Tests\Unit\App\Domain\Auth\Services;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Domain\Auth\DataTransferObjects\LoginDto;
use App\Domain\Auth\DataTransferObjects\SuccessfulAuthDto;
use App\Domain\Auth\Exceptions\IncorrectPasswordException;
use App\Domain\Auth\Exceptions\InvalidUserException;
use App\Domain\Auth\Services\Interfaces\AuthServiceInterface;
use App\Domain\User\Models\User;
use App\Domain\User\Services\Interfaces\UserServiceInterface;

class AuthServiceTest extends TestCase
{
    /** @var AuthServiceInterface */
    private $service;

    private $userServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userServiceMock = Mockery::mock(UserServiceInterface::class);
        $this->service = app(AuthServiceInterface::class, ['userService' => $this->userServiceMock]);
    }

    /**
     * @group services
     * @group auth
     */
    public function test_can_login(): void
    {
        $userData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ];

        $user = new User();
        $user->id = 1;
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = $userData['password'];

        $this->userServiceMock
            ->shouldReceive('firstByEmail')
            ->with($userData['email'])
            ->andReturn($user);

        Hash::shouldReceive('check')
            ->with($userData['password'], $user->password)
            ->andReturn(true);

        $login = $this->service->login(LoginDto::from([
            'email' => $userData['email'],
            'password' => $userData['password']
        ]));

        $this->assertInstanceOf(SuccessfulAuthDto::class, $login);
        $this->assertObjectHasProperty('accessToken', $login);
        $this->assertObjectHasProperty('tokenType', $login);
        $this->assertObjectHasProperty('expiresAt', $login);
        $this->assertNotEmpty($login->accessToken);
        $this->assertNotEmpty($login->tokenType);
        $this->assertNotEmpty($login->expiresAt);
        $this->assertSame('Bearer', $login->tokenType);
    }

    /**
     * @group services
     * @group auth
     */
    public function test_cannot_login_with_nonexistent_user(): void
    {
        $userData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ];

        $this->expectException(InvalidUserException::class);
        $this->expectExceptionMessage("Could not found a valid user with the email: {$userData['email']}.");

        $this->userServiceMock
            ->shouldReceive('firstByEmail')
            ->with($userData['email'])
            ->andReturnNull();

        $this->service->login(LoginDto::from([
            'email' => $userData['email'],
            'password' => $userData['password']
        ]));
    }

    /**
     * @group services
     * @group auth
     */
    public function test_cannot_login_with_incorrect_password(): void
    {
        $this->expectException(IncorrectPasswordException::class);
        $this->expectExceptionMessage('The password provided for this user is incorrect.');

        $userData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ];

        $user = new User();
        $user->id = 1;
        $user->name = $userData['name'];
        $user->email = $userData['email'];
        $user->password = $userData['password'];

        $this->userServiceMock
            ->shouldReceive('firstByEmail')
            ->with($userData['email'])
            ->andReturn($user);

        Hash::shouldReceive('check')
            ->with('wrong_password', $user->password)
            ->andReturn(false);

        $this->service->login(LoginDto::from([
            'email' => $userData['email'],
            'password' => 'wrong_password'
        ]));
    }

    /**
     * @group services
     * @group auth
     */
    public function test_generates_log_if_exception_occurs_when_try_to_login(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        $userData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password'
        ];

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[AuthService] Failed to login with the credentials provided.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->userServiceMock
            ->shouldReceive('firstByEmail')
            ->with($userData['email'])
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->login(LoginDto::from([
            'email' => $userData['email'],
            'password' => $userData['password']
        ]));
    }
}
