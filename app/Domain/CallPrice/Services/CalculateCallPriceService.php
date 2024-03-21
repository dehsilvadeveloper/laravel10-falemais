<?php

namespace App\Domain\CallPrice\Services;

use Illuminate\Http\Response;
use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;
use App\Domain\CallPrice\Exceptions\InvalidPlanMaxFreeMinutesException;

class CalculateCallPriceService
{
    public function calculateWithPlan(CallPriceCalculationDto $dto): float
    {
        $dataArray = $dto->toArray();
        list($callMinutes, $exceedingFeePercentage, $farePricePerMinute, $planMaxFreeMinutes) = $dataArray;

        if (!$planMaxFreeMinutes) {
            throw new InvalidPlanMaxFreeMinutesException(
                'Cannot proceed the calculation without a valid value for plan max free minutes.',
                Response::HTTP_BAD_REQUEST
            );
        }

        return (($callMinutes - $planMaxFreeMinutes) * $farePricePerMinute) 
            + (($exceedingFeePercentage / 100) * $farePricePerMinute);
    }

    public function calculateWithoutPlan(CallPriceCalculationDto $dto): float
    {
        $dataArray = $dto->toArray();
        list($callMinutes, $farePricePerMinute) = $dataArray;

        return $callMinutes * $farePricePerMinute;
    }
}
