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

/**
 * @group Fares
 *
 * Endpoints for managing fares
 */
class FareController extends Controller
{
    use ApiResponses;
    
    public function __construct(private FareServiceInterface $fareService)
    {
    }

    /**
     * List fares
     *
     * This endpoint lets you get a list of fares.
     * 
     * @responseField id integer The identifier of the fare.
     * @responseField ddd_origin string The DDD for the origin of the call.
     * @responseField ddd_destination string The DDD for the destination of the call.
     * @responseField price_per_minute integer The price per minute of the call.
     * 
     * @response status=200 scenario=success {
     *      "data": [
     *          {
     *              "id": 1,
     *              "ddd_origin": "011",
     *              "ddd_destination": "016",
     *              "price_per_minute": 1.9
     *          },
     *          {
     *              "id": 2,
     *              "ddd_origin": "016",
     *              "ddd_destination": "011",
     *              "price_per_minute": 2.9
     *          },
     *          {
     *              "id": 3,
     *              "ddd_origin": "011",
     *              "ddd_destination": "017",
     *              "price_per_minute": 1.7
     *          },
     *      ]
     * }
     * 
     * @response status=401 scenario="unauthenticated" {
     *      "message": "Unauthenticated."
     * }
     * 
     * @response status=500 scenario="unexpected error" {
     *      "message": "Internal Server Error."
     * }
     * 
     * @authenticated
     */
    public function getAll(): JsonResponse
    {
        try {
            $fares = $this->fareService->getAll();

            return (new FareCollection($fares))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $exception) {
            Log::error(
                '[FareController] Failed to get list of fares.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack_trace' => $exception->getTrace()
                ]
            );
            
            return $this->sendErrorResponse(
                message: 'An error has occurred. Could not get the fares list as requested.',
                code: $exception->getCode()
            );
        }
    }
}
