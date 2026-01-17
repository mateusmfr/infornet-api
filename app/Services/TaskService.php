<?php

namespace App\Services;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $repository
    ) {}

    public function getAllTasks(): Collection
    {
        return $this->repository->all();
    }

    public function getPaginatedTasks(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getTaskById(int $id): ?Task
    {
        return $this->repository->find($id);
    }

    public function createTask(array $data): Task
    {
        return $this->repository->create($data);
    }

    public function updateTask(Task $task, array $data): Task
    {
        return $this->repository->update($task, $data);
    }

    public function deleteTask(Task $task): bool
    {
        return $this->repository->delete($task);
    }
}
