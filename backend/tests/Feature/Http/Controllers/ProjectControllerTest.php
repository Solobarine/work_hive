<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list projects', function () {
    Project::factory()->count(3)->create(['user_id' => $this->user->id]);

    $response = $this->getJson('/api/projects');

    $response->assertStatus(200)
        ->assertJson(['status' => true])
        ->assertJsonCount(3, 'projects');
});

it('can create project', function () {
    $projectData = [
        'title' => 'New Project',
        'description' => 'New Description',
        'due_date' => '12-10-2024'
    ];

    $response = $this->postJson('/api/projects', $projectData);

    $response->assertStatus(201)
        ->assertJson([
            'status' => true,
            'project' => [
                'title' => 'New Project',
                'description' => 'New Description',
                'due_date' => '12-10-2024'
            ]
        ]);

    $this->assertDatabaseHas('projects', [
        'title' => 'New Project',
        'description' => 'New Description',
        'due_date' => '12-10-2024',
        'user_id' => $this->user->id
    ]);
});

it('validates project creation request', function () {
    $response = $this->postJson('/api/projects', []);

    $response->assertStatus(422)
        ->assertJson(['status' => false]);
});

it('can show a project', function () {
    $project = Project::factory()->create(['user_id' => $this->user->id]);

    $response = $this->getJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'project' => [
                'id' => $project->id
            ]
        ]);
});

it('can update a project', function () {
    $project = Project::factory()->create(['user_id' => $this->user->id]);

    $updatedData = [
        'title' => 'New Title'
    ];

    $response = $this->patchJson("/api/projects/{$project->id}", $updatedData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => 'true',
            'project' => [
                'id' => $project->id,
                'title' => 'New Title'
            ]
        ]);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'New Title'
    ]);
});

it('validates a project update', function () {
    $project = Project::factory()->create(['user_id' => $this->user->id]);

    $response = $this->patchJson("/api/projects/{$project->id}", ['title' => 42]);

    $response->assertStatus(422)
        ->assertJson(['status' => false]);
});

it('can delete a project', function () {
    $project = Project::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson("/api/projects/{$project->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'project' => [
                'id' => $project->id
            ]
        ]);

    $this->assertDatabaseMissing('projects', [
        'id' => $project->id
    ]);
});
