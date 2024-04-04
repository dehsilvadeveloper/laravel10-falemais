<?php

namespace App\Domain\Plan\Services;

use Throwable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Repositories\PlanRepositoryInterface;
use App\Domain\Plan\Services\Interfaces\PlanServiceInterface;

class PlanService implements PlanServiceInterface
{
    public function __construct(private PlanRepositoryInterface $planRepository)
    {
    }

    public function getAll(): Collection
    {
        try {
            return $this->planRepository->getAll();
        } catch (Throwable $exception) {
            Log::error(
                '[PlanService] Failed to get list of plans.',
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

    public function firstById(int $id): ?Plan
    {
        try {
            return $this->planRepository->firstById($id);
        } catch (Throwable $exception) {
            Log::error(
                '[PlanService] Failed to find a plan with the id provided.',
                [
                    'error_message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'data' => [
                        'id' => $id ?? null
                    ],
                    'stack_trace' => $exception->getTrace()
                ]
            );

            throw $exception;
        }
    }
}
