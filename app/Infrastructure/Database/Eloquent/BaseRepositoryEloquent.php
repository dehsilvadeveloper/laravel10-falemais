<?php

namespace App\Infrastructure\Database\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Database\Eloquent\Interfaces\RepositoryEloquentInterface;

class BaseRepositoryEloquent implements RepositoryEloquentInterface
{
    public function __construct(
        protected Model $model
    ) {
    }

    public function create(array $payload): ?Model
    {
        return $this->model->create($payload);
    }

    public function update(int $modelId, array $payload): Model
    {
        $item = $this->model->findOrFail($modelId);
        $item->update($payload);
        $item->refresh();

        return $item;
    }

    public function deleteById(int $modelId): bool
    {
        $item = $this->model->findOrFail($modelId);

        return $item->delete();
    }

    public function restoreById(int $modelId): bool
    {
        $item = $this->model->onlyTrashed()->findOrFail($modelId);

        return $item->restore();
    }

    public function permanentlyDeleteById(int $modelId): bool
    {
        $item = $this->model->withTrashed()->findOrFail($modelId);

        return $item->forceDelete();
    }

    public function getAll(array $columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    public function getAllTrashed(array $columns = ['*']): Collection
    {
        return $this->model->onlyTrashed()->get($columns);
    }

    public function getByField(string $field, mixed $value, array $columns = ['*']): Collection
    {
        return $this->model->where($field, '=', $value)->get($columns);
    }

    public function firstById(int $modelId, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->find($modelId);
    }

    public function firstTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->find($modelId);
    }

    public function firstOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->find($modelId);
    }

    public function firstByField(string $field, mixed $value, array $columns = ['*'], array $relations = []): ?Model
    {
        return $this->model->select($columns)->with($relations)->where($field, '=', $value)->first();
    }
}
