<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;
use App\Http\Resources\PlanCollection;
use App\Traits\Http\ApiResponses;

class PlanController extends Controller
{
    use ApiResponses;
    
    public function __construct(private PlanServiceInterface $planService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            $plans = $this->planService->getAll();

            return (new PlanCollection($plans))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            Log::error(
                '[PlanController] Failed to get list of plans.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack_trace' => $exception->getTrace()
                ]
            );
            
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the plans list as requested.',
                code: $exception->getCode()
            );
        }
    }
}
