<?php

namespace App\Domain\User\Services\Interfaces;

use App\Domain\User\Models\User;

interface UserServiceInterface
{
    public function firstByEmail(string $email): ?User;
}
