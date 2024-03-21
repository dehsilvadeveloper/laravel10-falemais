<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;
use App\Http\Resources\FareCollection;
use App\Traits\Http\ApiResponses;

class FareController extends Controller
{
    use ApiResponses;
    
    public function __construct(private FareServiceInterface $fareService)
    {
    }

    public function getAll(): JsonResponse
    {
        try {
            $fares = $this->fareService->getAll();

            return (new FareCollection($fares))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            Log::error(
                'Failed to get list of fares.',
                [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ]
            );
            
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the fares list as requested.',
                code: $exception->getCode()
            );
        }
    }
}
