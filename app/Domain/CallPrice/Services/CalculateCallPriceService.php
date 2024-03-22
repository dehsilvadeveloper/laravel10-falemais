<?php

namespace App\Domain\CallPrice\Services;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;
use App\Domain\CallPrice\Exceptions\InvalidPlanMaxFreeMinutesException;
use App\Domain\CallPrice\Services\Interfaces\CalculateCallPriceServiceInterface;

class CalculateCallPriceService implements CalculateCallPriceServiceInterface
{
    public function calculateWithPlan(CallPriceCalculationDto $dto): float
    {
        try {
            $dataArray = $dto->toArray();
            list(
                'call_minutes'=> $callMinutes, 
                'exceeding_fee_percentage' => $exceedingFeePercentage, 
                'fare_price_per_minute' => $farePricePerMinute,
                'plan_max_free_minutes' => $planMaxFreeMinutes
            ) = $dataArray;

            if (!$planMaxFreeMinutes) {
                throw new InvalidPlanMaxFreeMinutesException(
                    'Cannot proceed the calculation without a valid value for plan max free minutes.',
                    Response::HTTP_BAD_REQUEST
                );
            }

            $realCallMinutes = $callMinutes - $planMaxFreeMinutes;
            $realPricePerMinute = (($exceedingFeePercentage / 100) * $farePricePerMinute) + $farePricePerMinute;

            return $realCallMinutes * $realPricePerMinute;
        } catch (Throwable $exception) {
            Log::error(
                'Failed to calculate call price with plan.',
                [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'call_minutes'=> $callMinutes ?? null,
                        'exceeding_fee_percentage' => $exceedingFeePercentage ?? null,
                        'fare_price_per_minute' => $farePricePerMinute ?? null,
                        'plan_max_free_minutes' => $planMaxFreeMinutes ?? null
                    ],
                    'trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    public function calculateWithoutPlan(CallPriceCalculationDto $dto): float
    {
        try {
            $dataArray = $dto->toArray();
            list('call_minutes' => $callMinutes, 'fare_price_per_minute' => $farePricePerMinute) = $dataArray;

            return $callMinutes * $farePricePerMinute;
        } catch (Throwable $exception) {
            Log::error(
                'Failed to calculate call price without plan.',
                [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'call_minutes'=> $callMinutes ?? null,
                        'fare_price_per_minute' => $farePricePerMinute ?? null
                    ],
                    'trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
