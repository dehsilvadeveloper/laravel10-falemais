<?php

namespace App\Domain\Simulation\Services\Interfaces;

use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationResultDto;

interface SimulateCallPriceServiceInterface
{
    public function simulate(CallPriceSimulationDto $dto): CallPriceSimulationResultDto;
}
