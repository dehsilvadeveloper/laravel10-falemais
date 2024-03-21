<?php

namespace App\Infrastructure\Database\Eloquent;

use App\Infrastructure\Database\Eloquent\BaseRepositoryEloquent;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Repositories\FareRepositoryInterface;

class FareRepositoryEloquent extends BaseRepositoryEloquent implements FareRepositoryInterface
{
    public function __construct(Fare $model)
    {
        $this->model = $model;
    }
}
