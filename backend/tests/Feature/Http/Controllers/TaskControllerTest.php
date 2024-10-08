<?php

use App\Events\UpdateTask;
use App\Mail\TaskUpdated;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list tasks', function () {
    Task::factory()->count(3)->create(['user_id' => $this->user->id]);

    $response = $this->getJson('/api/tasks');

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
        ])
        ->assertJsonCount(3, 'tasks');
});

it('can create a task', function () {
    $taskData = [
        'title' => 'New Task',
        'description' => 'Task description',
        'status' => 'pending',
        'priority' => 'low',
    ];

    $response = $this->postJson('/api/tasks', $taskData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'task' => [
                'title' => 'New Task',
                'description' => 'Task description',
                'status' => 'pending',
                'priority' => 'low',
            ],
        ]);

    $this->assertDatabaseHas('tasks', [
        'title' => 'New Task',
        'description' => 'Task description',
        'user_id' => $this->user->id,
    ]);
});

it('validates task creation request', function () {
    $response = $this->postJson('/api/tasks', []);

    $response->assertStatus(422)
        ->assertJson([
            'status' => false,
        ]);
});

it('can show a task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->getJson("/api/tasks/{$task->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'task' => [
                'id' => $task->id,
            ],
        ]);
});

it('can update a task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $updatedData = [
        'title' => 'Updated Task Title',
        'status' => 'completed',
    ];

    $response = $this->patchJson("/api/tasks/{$task->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Task Updated Successfully',
            'task' => [
                'title' => 'Updated Task Title',
                'status' => 'completed',
            ],
        ]);

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Updated Task Title',
        'status' => 'completed',
    ]);
});

it('validates task update request', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->patchJson("/api/tasks/{$task->id}", ['status' => 'invalid-status']);

    $response->assertStatus(422)
        ->assertJson([
            'status' => false,
        ]);
});

it('can delete a task', function () {
    $task = Task::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson("/api/tasks/{$task->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Task Deleted Successfully',
        ]);

    $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
});

it('updates task status and dispatches the event', function () {
    Event::fake();

    $task = Task::factory()->create(['user_id' => $this->user->id]);
    $this->patch("/api/tasks/{$task->id}", ['status' => 'completed'])
        ->assertStatus(200);

    Event::assertDispatched(UpdateTask::class, function ($event) use ($task) {
        return $event->task->id === $task->id && $event->task->status === 'completed';
    });
});

it('can send an email when task is updated', function () {
    Mail::fake();


    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);


    $this->patchJson("/api/tasks/{$task->id}", ['status' => 'completed'])
        ->assertStatus(200);


    Mail::assertSent(TaskUpdated::class, function ($mail) use ($task) {
        return $mail->task->id === $task->id && $mail->task->status === 'completed';
    });
});
