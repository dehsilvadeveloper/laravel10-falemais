<?php

namespace App\Domain\User\Services;

use Throwable;
use Illuminate\Support\Facades\Log;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function firstById(int $id): ?User
    {
        try {
            return $this->userRepository->firstById($id);
        } catch (Throwable $exception) {
            Log::error(
                '[UserService] Failed to find a user with the id provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'id' => $id ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    public function firstByEmail(string $email): ?User
    {
        try {
            return $this->userRepository->firstByField('email', $email, ['id', 'name', 'email', 'password']);
        } catch (Throwable $exception) {
            Log::error(
                '[UserService] Failed to find a user with the email provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'email' => $email ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
