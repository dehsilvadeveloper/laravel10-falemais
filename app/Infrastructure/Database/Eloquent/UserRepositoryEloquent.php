<?php

namespace App\Infrastructure\Database\Eloquent;

use App\Infrastructure\Database\Eloquent\BaseRepositoryEloquent;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
