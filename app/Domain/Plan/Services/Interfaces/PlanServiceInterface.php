<?php

namespace App\Domain\Plan\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PlanServiceInterface
{
    public function getAll(): Collection;
}
