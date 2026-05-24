<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data_api(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token',
                'token_type',
                'expires_in'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_registration_requires_name(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_registration_requires_email(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_registration_requires_valid_email_format(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
        $this->assertDatabaseMissing('users', ['name' => 'Test User']);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_registration_requires_password(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    public function test_password_must_be_at_least_8_characters(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_password_confirmation_is_required(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    public function test_password_confirmation_must_match(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }

    public function test_password_is_hashed_in_database(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertNotNull($user);
        $this->assertNotEquals('password123', $user->password);
    }

    public function test_registered_user_can_login_immediately(): void
    {
        $registerResponse = $this->postJson('/api/auth/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $registerResponse->assertStatus(201);

        $loginResponse = $this->postJson('/api/auth/login', [
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200);
        $loginResponse->assertJson(['success' => true]);
    }

    public function test_registration_returns_jwt_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Token Test User',
            'email' => 'tokentest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'token',
                'token_type',
                'expires_in',
            ]
        ]);

        $token = $response->json('data.token');
        $this->assertNotEmpty($token);
    }

    public function test_registration_default_role_is_user(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Role Test User',
            'email' => 'roletest@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'user' => [
                    'role' => 'user',
                ]
            ]
        ]);
    }
}