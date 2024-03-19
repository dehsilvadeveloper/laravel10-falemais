<?php

namespace App\Infrastructure\Database\Eloquent;

use App\Infrastructure\Database\Eloquent\BaseRepositoryEloquent;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Repositories\PlanRepositoryInterface;

class PlanRepositoryEloquent extends BaseRepositoryEloquent implements PlanRepositoryInterface
{
    public function __construct(Plan $model)
    {
        $this->model = $model;
    }
}
