<?php

namespace App\Domain\Plan\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Domain\Plan\Models\Plan;

interface PlanServiceInterface
{
    public function getAll(): Collection;

    public function firstById(int $id): ?Plan;
}
