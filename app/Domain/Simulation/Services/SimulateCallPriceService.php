<?php

namespace App\Domain\Simulation\Services;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\Common\ValueObjects\DddObject;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;

class SimulateCallPriceService implements SimulateCallPriceServiceInterface
{
    public function __construct(
        private FareServiceInterface $fareService,
        private PlanServiceInterface $planService
    ) {
    }

    public function simulate(CallPriceSimulationDto $dto)
    {
        try {
            $this->verifyFareExists($dto->dddOrigin, $dto->dddDestination);
            $this->verifyPlanExists($dto->planId);
        } catch (Throwable $exception) {
            Log::error(
                '[SimulateCallPriceService] Failed to simulate the calculation of the call price.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    private function verifyFareExists(DddObject $dddOrigin, DddObject $dddDestination): void
    {
        $fare = $this->fareService->firstWhere([
            'ddd_origin' => $dddOrigin->value(), 
            'ddd_destination' => $dddDestination->value()
        ]);

        if (!$fare) {
            throw new \Exception(
                'Cannot proceed. Could no find a fare with the ddd origin and ddd destination provided.',
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    private function verifyPlanExists(int $planId): void
    {
        $plan = $this->planService->firstById($planId);

        if (!$plan) {
            throw new \Exception(
                'Cannot proceed. Could no find a plan with the id provided.',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
