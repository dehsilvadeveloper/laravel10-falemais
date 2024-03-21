<?php

namespace App\Domain\Fare\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface FareServiceInterface
{
    public function getAll(): Collection;
}
