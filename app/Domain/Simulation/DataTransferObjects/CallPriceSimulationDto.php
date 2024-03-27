<?php

namespace App\Domain\Simulation\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use App\Domain\Common\ValueObjects\DddObject;

#[MapInputName(SnakeCaseMapper::class), MapOutputName(SnakeCaseMapper::class)]
class CallPriceSimulationDto extends Data
{
    public function __construct(
        public DddObject $dddOrigin,
        public DddObject $dddDestination,
        public int $callMinutes,
        public int $planId
    ) {
    }
}
