<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('logs in a user successfully', function () {
    // Create a user
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    // Attempt login
    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    // Assert login success
    $response->assertStatus(200);
    $response->assertJson([
        'status' => true,
    ]);
});

it('fails to log in with incorrect credentials', function () {
    // Create a user
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    // Attempt login with wrong password
    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'wrongpassword',
    ]);

    // Assert login failure
    $response->assertStatus(401);
    $response->assertJson([
        'status' => false,
        'error' => 'Invalid Email or Password',
    ]);
});

it('fails login validation if email or password is missing', function () {
    // Attempt login with missing email
    $response = $this->postJson('/api/login', [
        'password' => 'password123',
    ]);

    // Assert validation error
    $response->assertStatus(403);
    $response->assertJsonStructure([
        'status',
        'error',
    ]);
});

it('registers a user successfully', function () {
    // Attempt user registration
    $response = $this->postJson('/api/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    // Assert registration success
    $response->assertStatus(201);
    $response->assertJson([
        'status' => true,
        'message' => 'User Registered Successfully',
    ]);

    // Ensure the user was created in the database
    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});

it('fails to register if the user already exists', function () {
    // Create an existing user
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    // Attempt to register with the same email
    $response = $this->postJson('/api/register', [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => 'existing@example.com',
        'password' => 'password123',
    ]);

    // Assert registration failure
    $response->assertStatus(403);
    $response->assertJson([
        'status' => false,
        'error' => 'User with Email Already Exists',
    ]);
});

it('fails registration validation if fields are missing or invalid', function () {
    // Attempt to register with missing fields
    $response = $this->postJson('/api/register', [
        'email' => 'john@example.com',
    ]);

    // Assert validation error
    $response->assertStatus(422);
    $response->assertJsonStructure([
        'status',
        'error',
    ]);
});

it('logs out a user successfully', function () {
    // Fake user login
    $user = User::factory()->create();
    $this->actingAs($user);

    // Attempt logout
    $response = $this->postJson('/api/logout');

    // Assert logout success
    $response->assertStatus(200);
    $response->assertJson([
        'status' => 'true',
        'message' => 'Logged Out Successfully',
    ]);
});
