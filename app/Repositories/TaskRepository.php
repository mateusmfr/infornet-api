<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function __construct(
        protected Task $model
    ) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function find(int $id): ?Task
    {
        return $this->model->find($id);
    }

    public function create(array $data): Task
    {
        return $this->model->create($data);
    }

    public function update($model, array $data)
    {
        $model->update($data);
        return $model->fresh();
    }

    public function delete($model): bool
    {
        return $model->delete();
    }
}
