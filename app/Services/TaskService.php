<?php

namespace App\Services;

use App\Contracts\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $repository
    ) {}

    public function getAllTasks(): Collection
    {
        return $this->repository->all();
    }

    public function getPaginatedTasks(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    public function getTaskById(int $id): ?Task
    {
        return $this->repository->find($id);
    }

    public function createTask(array $data): Task
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            Log::error('Error creating task: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateTask(Task $task, array $data): Task
    {
        try {
            return $this->repository->update($task, $data);
        } catch (\Exception $e) {
            Log::error('Error updating task: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteTask(Task $task): bool
    {
        try {
            return $this->repository->delete($task);
        } catch (\Exception $e) {
            Log::error('Error deleting task: ' . $e->getMessage());
            throw $e;
        }
    }
}
