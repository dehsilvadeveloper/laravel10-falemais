<?php

namespace App\Domain\Simulation\Services;

use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;
use App\Domain\Simulation\Services\Interfaces\SimulateCallPriceServiceInterface;

class SimulateCallPriceService implements SimulateCallPriceServiceInterface
{
    public function __construct()
    {
    }

    public function simulate(CallPriceSimulationDto $dto)
    {

    }
}
