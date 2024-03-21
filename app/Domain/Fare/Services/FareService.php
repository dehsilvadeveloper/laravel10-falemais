<?php

namespace App\Domain\Fare\Services;

use Throwable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Domain\Fare\Repositories\FareRepositoryInterface;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;

class FareService implements FareServiceInterface
{
    public function __construct(private FareRepositoryInterface $fareRepository)
    {
    }

    public function getAll(): Collection
    {
        try {
            return $this->fareRepository->getAll();
        } catch (Throwable $exception) {
            Log::error(
                'Failed to get list of fares.',
                [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
