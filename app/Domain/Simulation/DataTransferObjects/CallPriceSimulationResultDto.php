<?php

namespace App\Domain\Simulation\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class), MapOutputName(SnakeCaseMapper::class)]
class CallPriceSimulationResultDto extends Data
{
    public function __construct(
        public float $priceWithPlan,
        public float $priceWithoutPlan
    ) {
    }
}
