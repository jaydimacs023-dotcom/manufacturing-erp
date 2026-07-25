<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app($this->modelClass());
    }

    /**
     * Get the model class name.
     */
    abstract protected function modelClass(): string;

    /**
     * Get all records.
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Get paginated records.
     */
    public function paginate(int $perPage = 15, array $columns = ['*'], string $orderBy = 'created_at', string $direction = 'desc'): LengthAwarePaginator
    {
        return $this->model->orderBy($orderBy, $direction)->paginate($perPage, $columns);
    }

    /**
     * Find record by ID.
     */
    public function find(int $id, array $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find record by UUID.
     */
    public function findByUuid(string $uuid, array $columns = ['*']): ?Model
    {
        return $this->model->where('uuid', $uuid)->first($columns);
    }

    /**
     * Find records by field value.
     */
    public function findByField(string $field, mixed $value, array $columns = ['*']): Collection
    {
        return $this->model->where($field, $value)->get($columns);
    }

    /**
     * Find first record by field value.
     */
    public function findFirstByField(string $field, mixed $value, array $columns = ['*']): ?Model
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a record.
     */
    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    /**
     * Update records by field.
     */
    public function updateByField(string $field, mixed $value, array $data): int
    {
        return $this->model->where($field, $value)->update($data);
    }

    /**
     * Delete a record (soft delete).
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Force delete a record.
     */
    public function forceDelete(Model $model): bool
    {
        return $model->forceDelete();
    }

    /**
     * Restore a soft-deleted record.
     */
    public function restore(Model $model): bool
    {
        return $model->restore();
    }

    /**
     * Get count of records.
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * Check if records exist.
     */
    public function exists(array $conditions): bool
    {
        $query = $this->model->newQuery();
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        return $query->exists();
    }

    /**
     * Begin a new query.
     */
    public function newQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Get only trashed (soft deleted) records.
     */
    public function onlyTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Get records with trashed included.
     */
    public function withTrashed(): Collection
    {
        return $this->model->withTrashed()->get();
    }
}

