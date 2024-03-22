<?php

namespace App\Domain\CallPrice\Services\Interfaces;

use App\Domain\CallPrice\DataTransferObjects\CallPriceCalculationDto;

interface CalculateCallPriceServiceInterface
{
    public function calculateWithPlan(CallPriceCalculationDto $dto): float;

    public function calculateWithoutPlan(CallPriceCalculationDto $dto): float;
}
