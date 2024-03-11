<?php

namespace App\Infrastructure\Database\Eloquent\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryEloquentInterface
{
    public function create(array $payload): ?Model;

    public function update(int $modelId, array $payload): Model;

    public function deleteById(int $modelId): bool;

    public function restoreById(int $modelId): bool;

    public function permanentlyDeleteById(int $modelId): bool;

    public function getAll(array $columns = ['*']): Collection;

    public function getAllTrashed(array $columns = ['*']): Collection;

    public function getByField(string $field, mixed $value, array $columns = ['*']): Collection;

    public function firstById(int $modelId, array $columns = ['*'], array $relations = []): ?Model;

    public function firstTrashedById(int $modelId): ?Model;

    public function firstOnlyTrashedById(int $modelId): ?Model;

    public function firstByField(string $field, mixed $value, array $columns = ['*'], array $relations = []): ?Model;
}
