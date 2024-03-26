<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SimulateCallPriceRequest;
use App\Traits\Http\ApiResponses;

class CallPriceSimulationController extends Controller
{
    use ApiResponses;
    
    public function __construct(private SimulateCallPriceServiceInterface $simulateCallPriceService)
    {
    }

    public function simulate(SimulateCallPriceRequest $request): JsonResponse
    {
        try {
            $dto = CallPriceSimulationDto::from(...$request->validated());

            $result = $this->simulateCallPriceService->simulate($dto);

            return $this->sendSuccessResponse(
                data: $result->toArray(),
                code: Response::HTTP_OK
            );
        } catch (Throwable $exception) {
            Log::error(
                'Failed to simulate the call price.',
                [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ]
            );
            
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not simulate the call price as requested.',
                code: $exception->getCode()
            );
        }
    }
}