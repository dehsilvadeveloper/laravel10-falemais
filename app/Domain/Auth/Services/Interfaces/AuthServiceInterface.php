<?php

namespace App\Domain\Auth\Services\Interfaces;

interface AuthServiceInterface
{
    public function login(LoginDto $dto): SuccessfulAuthDto;
}
