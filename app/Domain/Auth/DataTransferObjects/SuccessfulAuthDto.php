<?php

namespace App\Domain\Auth\DataTransferObjects;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class), MapOutputName(SnakeCaseMapper::class)]
class SuccessfulAuthDto extends Data
{
    public function __construct(
        public string $accessToken,
        public string $tokenType,
        public string $expiresAt
    ) {
    }
}
