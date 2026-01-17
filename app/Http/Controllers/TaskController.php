<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Traits\ApiResponse;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected TaskService $taskService
    ) {}

    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getPaginatedTasks();

        return $this->successResponse(
            TaskResource::collection($tasks)->response()->getData(),
            'Tasks retrieved successfully'
        );
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask($request->validated());

        return $this->createdResponse(
            new TaskResource($task),
            'Task created successfully'
        );
    }

    public function show(Task $task): JsonResponse
    {
        return $this->successResponse(
            new TaskResource($task),
            'Task retrieved successfully'
        );
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $updatedTask = $this->taskService->updateTask($task, $request->validated());

        return $this->successResponse(
            new TaskResource($updatedTask),
            'Task updated successfully'
        );
    }

    public function destroy(Task $task): Response
    {
        $this->taskService->deleteTask($task);

        return $this->noContentResponse();
    }
}
