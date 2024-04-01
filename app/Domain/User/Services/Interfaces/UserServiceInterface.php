<?php

namespace App\Domain\User\Services\Interfaces;

use App\Domain\User\Models\User;

interface UserServiceInterface
{
    public function firstById(int $id): ?User;
    
    public function firstByEmail(string $email): ?User;
}
