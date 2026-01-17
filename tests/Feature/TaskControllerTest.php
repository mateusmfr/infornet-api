<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_tasks_with_pagination(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            Task::create([
                'title' => "Task {$i}",
                'description' => "Description {$i}",
                'completed' => false
            ]);
        }

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'data' => [
                        '*' => ['id', 'title', 'description', 'completed', 'created_at', 'updated_at']
                    ],
                    'links',
                    'meta' => ['current_page', 'last_page', 'per_page', 'total']
                ]
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'meta' => [
                        'per_page' => 10,
                        'total' => 15,
                        'last_page' => 2
                    ]
                ]
            ]);
    }

    public function test_can_create_task_with_valid_data(): void
    {
        $taskData = [
            'title' => 'New Task',
            'description' => 'Task description',
            'completed' => false
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Task created successfully',
                'data' => [
                    'title' => 'New Task',
                    'description' => 'Task description',
                    'completed' => false
                ]
            ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'description' => 'Task description',
            'completed' => false
        ]);
    }

    public function test_cannot_create_task_without_title(): void
    {
        $taskData = [
            'description' => 'Task without title',
            'completed' => false
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_can_show_task_by_id(): void
    {
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test Description',
            'completed' => true
        ]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'title' => 'Test Task',
                    'description' => 'Test Description',
                    'completed' => true
                ]
            ]);
    }

    public function test_returns_404_when_task_not_found(): void
    {
        $response = $this->getJson('/api/tasks/999');

        $response->assertStatus(404);
    }

    public function test_can_update_task(): void
    {
        $task = Task::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'completed' => false
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'completed' => true
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Task updated successfully',
                'data' => [
                    'id' => $task->id,
                    'title' => 'Updated Title',
                    'description' => 'Updated Description',
                    'completed' => true
                ]
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'completed' => true
        ]);
    }

    public function test_can_partially_update_task(): void
    {
        $task = Task::create([
            'title' => 'Original Title',
            'description' => 'Original Description',
            'completed' => false
        ]);

        $updateData = ['completed' => true];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $task->id,
                    'title' => 'Original Title', // Unchanged
                    'completed' => true // Changed
                ]
            ]);
    }

    public function test_returns_404_when_updating_non_existent_task(): void
    {
        $updateData = ['title' => 'Updated Title'];

        $response = $this->putJson('/api/tasks/999', $updateData);

        $response->assertStatus(404);
    }

    public function test_can_delete_task(): void
    {
        $task = Task::create([
            'title' => 'Task to delete',
            'description' => 'This will be deleted',
            'completed' => false
        ]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }

    public function test_returns_404_when_deleting_non_existent_task(): void
    {
        $response = $this->deleteJson('/api/tasks/999');

        $response->assertStatus(404);
    }

    public function test_title_cannot_exceed_255_characters(): void
    {
        $taskData = [
            'title' => str_repeat('a', 256),
            'description' => 'Valid description'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_completed_must_be_boolean(): void
    {
        $taskData = [
            'title' => 'Test Task',
            'completed' => 'not-a-boolean'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['completed']);
    }
}
