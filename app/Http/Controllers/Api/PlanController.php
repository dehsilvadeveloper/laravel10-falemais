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

/**
 * @group Plans
 *
 * Endpoints for managing plans
 */
class PlanController extends Controller
{
    use ApiResponses;
    
    public function __construct(private PlanServiceInterface $planService)
    {
    }

    /**
     * List plans
     *
     * This endpoint lets you get a list of plans.
     * 
     * @responseField id integer The identifier of the plan.
     * @responseField name string The name of the plan.
     * @responseField max_free_minutes integer The total free minutes to which the customer using the plan is entitled.
     * 
     * @response status=200 scenario=success {
     *      "data": [
     *          {
     *              "id": 1,
     *              "name": "FaleMais 30",
     *              "max_free_minutes": 30
     *          },
     *          {
     *              "id": 2,
     *              "name": "FaleMais 60",
     *              "max_free_minutes": 60
     *          },
     *          {
     *              "id": 3,
     *              "name": "FaleMais 120",
     *              "max_free_minutes": 120
     *          }
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
