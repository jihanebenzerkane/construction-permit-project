<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

test('POST api auth token returns bearer token for valid credentials', function () {
    $response = $this->postJson('/api/auth/token', [
        'email' => 'admin@test.com',
        'password' => 'password',
    ]);

    $response->assertCreated()
        ->assertJsonStructure(['token', 'token_type', 'user' => ['id', 'email', 'role']]);
});

test('POST api auth token rejects invalid credentials', function () {
    $this->postJson('/api/auth/token', [
        'email' => 'admin@test.com',
        'password' => 'wrong-password',
    ])->assertStatus(422);
});

test('GET api auth me returns user when bearer token is valid', function () {
    $token = $this->postJson('/api/auth/token', [
        'email' => 'citoyen@test.com',
        'password' => 'password',
    ])->json('token');

    $this->withToken($token)
        ->getJson('/api/auth/me')
        ->assertOk()
        ->assertJsonPath('email', 'citoyen@test.com')
        ->assertJsonPath('role', 'citoyen');
});

test('GET api statuses returns list when authenticated', function () {
    $token = $this->postJson('/api/auth/token', [
        'email' => 'agent@test.com',
        'password' => 'password',
    ])->json('token');

    $this->withToken($token)
        ->getJson('/api/statuses')
        ->assertOk()
        ->assertJsonIsArray();
});

test('DELETE api auth token revokes the current token', function () {
    $token = $this->postJson('/api/auth/token', [
        'email' => 'admin@test.com',
        'password' => 'password',
    ])->json('token');

    $this->withToken($token)
        ->deleteJson('/api/auth/token')
        ->assertOk();

    $this->withToken($token)
        ->getJson('/api/auth/me')
        ->assertStatus(401);
});

test('admin can list roles via api with bearer token', function () {
    $token = $this->postJson('/api/auth/token', [
        'email' => 'admin@test.com',
        'password' => 'password',
    ])->json('token');

    $this->withToken($token)
        ->getJson('/api/admin/roles')
        ->assertOk()
        ->assertJsonIsArray();
});

test('citizen cannot access admin roles api', function () {
    $token = $this->postJson('/api/auth/token', [
        'email' => 'citoyen@test.com',
        'password' => 'password',
    ])->json('token');

    $this->withToken($token)
        ->getJson('/api/admin/roles')
        ->assertForbidden();
});
