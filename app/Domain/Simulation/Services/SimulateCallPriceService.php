<?php

namespace App\Domain\Simulation\Services;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;
use App\Domain\CallPrice\Services\Interfaces\CalculateCallPriceServiceInterface;
use App\Domain\Common\ValueObjects\DddObject;
use App\Domain\Fare\Exceptions\FareNotFoundException;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;
use App\Domain\Plan\Exceptions\PlanNotFoundException;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationResultDto;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;

class SimulateCallPriceService implements SimulateCallPriceServiceInterface
{
    public function __construct(
        private FareServiceInterface $fareService,
        private PlanServiceInterface $planService,
        private CalculateCallPriceServiceInterface $calculateCallPriceService
    ) {
    }

    public function simulate(CallPriceSimulationDto $dto): CallPriceSimulationResultDto
    {
        try {
            $fare = $this->getFare($dto->dddOrigin, $dto->dddDestination);
            $plan = $this->getPlan($dto->planId);

            $priceWithPlan = $this->simulateWithPlan($dto, $fare, $plan);
            $priceWithoutPlan = $this->simulateWithoutPlan($dto, $fare);

            return CallPriceSimulationResultDto::from([
                'price_with_plan' => $priceWithPlan,
                'price_without_plan' => $priceWithoutPlan
            ]);
        } catch (Throwable $exception) {
            Log::error(
                '[SimulateCallPriceService] Failed to simulate the calculation of the call price.',
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

    private function getFare(DddObject $dddOrigin, DddObject $dddDestination): Fare
    {
        $fare = $this->fareService->firstWhere([
            'ddd_origin' => $dddOrigin->value(), 
            'ddd_destination' => $dddDestination->value()
        ]);

        if (!$fare) {
            throw new FareNotFoundException(
                'Cannot proceed. Could no find a fare with the ddd origin and ddd destination provided.',
                Response::HTTP_BAD_REQUEST
            );
        }

        return $fare;
    }

    private function getPlan(int $planId): Plan
    {
        $plan = $this->planService->firstById($planId);

        if (!$plan) {
            throw new PlanNotFoundException(
                'Cannot proceed. Could no find a plan with the id provided.',
                Response::HTTP_BAD_REQUEST
            );
        }

        return $plan;
    }

    private function simulateWithPlan(CallPriceSimulationDto $dto, Fare $fare, Plan $plan): float
    {
        return $this->calculateCallPriceService->calculateWithPlan(
            CallPriceCalculationDto::from([
                'call_minutes'=> $dto->callMinutes, 
                'fare_price_per_minute' => $fare->price_per_minute,
                'plan_max_free_minutes' => $plan->max_free_minutes
            ])
        );
    }

    private function simulateWithoutPlan(CallPriceSimulationDto $dto, Fare $fare): float
    {
        return $this->calculateCallPriceService->calculateWithoutPlan(
            CallPriceCalculationDto::from([
                'call_minutes'=> $dto->callMinutes, 
                'fare_price_per_minute' => $fare->price_per_minute
            ])
        );
    }
}
