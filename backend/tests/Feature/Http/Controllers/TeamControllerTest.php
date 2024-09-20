<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('creates a team successfully', function () {
    $requestData = [
        'project_id' => 1,
        'name' => 'Team Alpha'
    ];

    $response = $this->postJson('/api/teams', $requestData);

    $response->assertStatus(201)
        ->assertJson([
            'status' => true,
            'message' => 'Team created Successfully',
        ]);

    $this->assertDatabaseHas('teams', ['name' => 'Team Alpha']);
});

it('returns validation errors when creating a team with invalid data', function () {
    $requestData = [
        'project_id' => 'invalid',
        'name' => ''
    ];

    $response = $this->postJson('/api/teams', $requestData);

    $response->assertStatus(422)
        ->assertJsonStructure(['status', 'error']);
});

it('assigns a team member successfully', function () {
    $team = Team::factory()->create(['project_id' => 2]);

    $requestData = ['user_id' => 2];

    $response = $this->postJson("/api/teams/{$team->id}/members", $requestData);

    $response->assertStatus(201)
        ->assertJson([
            'status' => true,
            'message' => 'Team Member addded Successfully',
        ]);

    $this->assertDatabaseHas('team_members', [
        'team_id' => $team->id,
        'user_id' => 2
    ]);
});

it('returns validation errors when assigning a team member with invalid data', function () {
    $team = Team::factory()->create(['project_id' => 4]);

    $requestData = ['user_id' => 'invalid'];

    $response = $this->postJson("/api/teams/{$team->id}/members", $requestData);

    $response->assertStatus(422)
        ->assertJsonStructure(['status', 'error']);
});

it('removes a team member successfully', function () {
    $team = Team::factory()->create(['project_id' => 3]);
    $team->members()->create(['user_id' => 2]);

    $requestData = ['user_id' => 2];

    $response = $this->postJson("/api/teams/{$team->id}/members/remove", $requestData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Team Member removed Successfully',
        ]);

    $this->assertDatabaseMissing('team_members', [
        'team_id' => $team->id,
        'user_id' => 2
    ]);
});

it('returns validation errors when removing a team member with invalid data', function () {
    $team = Team::factory()->create(['project_id' => 6]);

    $requestData = ['team_member_id' => 'invalid'];

    $response = $this->postJson("/api/teams/{$team->id}/members/remove", $requestData);

    $response->assertStatus(422)
        ->assertJsonStructure(['status', 'error']);
});

it('deletes a team successfully', function () {
    $team = Team::factory()->create(['project_id' => 6]);

    $response = $this->deleteJson("/api/teams/{$team->id}");

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'message' => 'Team Deleted Successfully'
        ]);

    $this->assertDatabaseMissing('teams', ['id' => $team->id]);
});
