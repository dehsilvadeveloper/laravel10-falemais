<?php

namespace App\Domain\Auth\Services;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Domain\Auth\Services\Interfaces\AuthServiceInterface;
use App\Domain\User\Models\User;
use App\Domain\User\Services\Interfaces\UserServiceInterface;

class AuthService implements AuthServiceInterface
{
    public function __construct(private UserServiceInterface $userService)
    {
    }

    public function login(LoginDto $dto): SuccessfulAuthDto
    {
        try {
            $validatedUser = $this->validateUser($dto->email, $dto->password);

            $validatedUser->tokens()->delete();

            $expiresAt = now()->addMinutes(5);

            $token = $validatedUser->createToken(
                $dto->email,
                ['*'],
                $expiresAt
            )->plainTextToken;

            return SuccessfulAuthDto::from([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiresAt->format('Y-m-d H:i:s')
            ]);
        } catch (Throwable $exception) {
            Log::error(
                '[AuthService] Failed to login with the credentials provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'received_dto_data' => $dto->toArray() ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    private function validateUser(string $email, string $password): User
    {
        $user = $this->userService->firstByEmail($email);

        if (!$user) {
            throw new InvalidUserException(
                `Could not found a valid user with the email: $email.`,
                Response::HTTP_BAD_REQUEST
            );
        }

        if (!Hash::check($password, $user->password)) {
            throw new IncorrectPasswordException(
                `The password provided for this user is incorrect.`,
                Response::HTTP_BAD_REQUEST
            );
        }

        return $user;
    }
}
