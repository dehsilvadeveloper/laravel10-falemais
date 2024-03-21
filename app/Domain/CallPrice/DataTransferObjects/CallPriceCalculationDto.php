<?php

namespace App\Domain\CallPrice\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class), MapOutputName(SnakeCaseMapper::class)]
class CallPriceCalculationDto extends Data
{
    public function __construct(
        public int $callMinutes,
        public float $exceedingFeePercentage,
        public float $farePricePerMinute,
        public ?int $planMaxFreeMinutes = null
    ) {
    }
}
