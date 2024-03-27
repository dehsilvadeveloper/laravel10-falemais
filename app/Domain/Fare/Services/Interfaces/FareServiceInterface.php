<?php

namespace App\Domain\Fare\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Domain\Fare\Models\Fare;

interface FareServiceInterface
{
    public function getAll(): Collection;

    public function firstWhere(array $where): ?Fare;
}
