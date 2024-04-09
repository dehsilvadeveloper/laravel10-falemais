<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\Auth\DataTransferObjects\LoginDto;
use App\Domain\Auth\Exceptions\IncorrectPasswordException;
use App\Domain\Auth\Exceptions\InvalidUserException;
use App\Domain\Auth\Services\Interfaces\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Traits\Http\ApiResponses;

/**
 * @group Authentication
 *
 * Endpoints for managing API authentication
 */
class AuthController extends Controller
{
    use ApiResponses;
    
    public function __construct(private AuthServiceInterface $authService)
    {
    }

    /**
     * Login
     *
     * This endpoint lets you login an API user, generating an access token for him.
     * 
     * @responseField access_token string The access token that will be used to authenticate API requests.
     * @responseField token_type string The type of token generated.
     * @responseField expires_at string The date and time in which the token will expire.
     * 
     * @response status=200 scenario=success {
     *      "data": {
     *          "access_token": "1|laravel10_falemaisUI8A7aHrlN0XCyKApJCfO2uzK9Gc4X8DWZtFJbCY4d735783",
     *          "token_type": "Bearer",
     *          "expires_at": "2024-02-01 12:27:37"
     *      }
     * }
     * 
     * @response status=400 scenario="user with email provided not found" {
     *      "message": "Could not found a valid user with the email: test@test.com."
     * }
     * 
     * @response status=400 scenario="password incorrect" {
     *      "message": "The password provided for this user is incorrect."
     * }
     * 
     * @response status=500 scenario="unexpected error" {
     *      "message": "Internal Server Error."
     * }
     * 
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $dto = LoginDto::from([
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);

            $result = $this->authService->login($dto);

            return $this->sendSuccessResponse(
                data: $result->toArray(),
                code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            Log::error(
                '[AuthController] Failed to login with the credentials provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'received_data' => $request->all() ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            $exceptionTypes = [InvalidUserException::class, IncorrectPasswordException::class];

            $errorMessage = in_array(get_class($exception), $exceptionTypes)
                ? $exception->getMessage() 
                : 'An error has occurred. Could not login with the credentials provided as requested.';

            return $this->sendErrorResponse(
                message: $errorMessage,
                code: $exception->getCode()
            );
        }
    }
}
