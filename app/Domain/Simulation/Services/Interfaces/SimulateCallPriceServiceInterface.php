<?php

namespace App\Domain\Simulation\Services\Interfaces;

use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;

interface SimulateCallPriceServiceInterface
{
    public function simulate(CallPriceSimulationDto $dto);
}
