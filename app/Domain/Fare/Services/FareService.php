<?php

namespace App\Domain\Fare\Services;

use Throwable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Domain\Fare\Models\Fare;
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
                '[FareService] Failed to get list of fares.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }

    public function firstWhere(array $where): ?Fare
    {
        try {
            return $this->fareRepository->firstWhere($where);
        } catch (Throwable $exception) {
            Log::error(
                '[FareService] Failed to find a fare with the attributes provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
