<?php

namespace App\Domain\Auth\Services\Interfaces;

use App\Domain\Auth\DataTransferObjects\LoginDto;
use App\Domain\Auth\DataTransferObjects\SuccessfulAuthDto;

interface AuthServiceInterface
{
    public function login(LoginDto $dto): SuccessfulAuthDto;
}
