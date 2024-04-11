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
            [
                'call_minutes' => $callMinutes,
                'exceeding_fee_percentage' => $exceedingFeePercentage,
                'fare_price_per_minute' => $farePricePerMinute,
                'plan_max_free_minutes' => $planMaxFreeMinutes
            ] = $dataArray;

            if (!$planMaxFreeMinutes) {
                throw new InvalidPlanMaxFreeMinutesException(
                    'Cannot proceed the calculation without a valid value for plan max free minutes.',
                    Response::HTTP_BAD_REQUEST
                );
            }

            $realCallMinutes = $callMinutes - $planMaxFreeMinutes;
            $realPricePerMinute = (($exceedingFeePercentage / 100) * $farePricePerMinute) + $farePricePerMinute;
            $result = $realCallMinutes * $realPricePerMinute;

            return ($result > 0) ? $result : 0;
        } catch (Throwable $exception) {
            Log::error(
                '[CalculateCallPriceService] Failed to calculate call price with plan.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'call_minutes' => $callMinutes ?? null,
                        'exceeding_fee_percentage' => $exceedingFeePercentage ?? null,
                        'fare_price_per_minute' => $farePricePerMinute ?? null,
                        'plan_max_free_minutes' => $planMaxFreeMinutes ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    public function calculateWithoutPlan(CallPriceCalculationDto $dto): float
    {
        try {
            $dataArray = $dto->toArray();
            ['call_minutes' => $callMinutes, 'fare_price_per_minute' => $farePricePerMinute] = $dataArray;

            return $callMinutes * $farePricePerMinute;
        } catch (Throwable $exception) {
            Log::error(
                '[CalculateCallPriceService] Failed to calculate call price without plan.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'call_minutes' => $callMinutes ?? null,
                        'fare_price_per_minute' => $farePricePerMinute ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
