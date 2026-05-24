<?php

namespace Tests\Feature;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials_api(): void
    {
        $user = User::factory()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'api@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
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
        $response->assertJson([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => 'user',
                ]
            ]
        ]);
    }

    public function test_user_cannot_login_with_invalid_credentials_api(): void
    {
        User::factory()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'api@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['success' => false]);
    }

    public function test_login_requires_email_and_password(): void
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/logout');

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_user_can_register_api(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201);
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
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_registration_requires_valid_data(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_user_can_get_profile(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/profile');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'user',
            ]
        ]);
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
            'name' => 'Original Name',
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->putJson('/api/profile', [
                'name' => 'Updated Name',
                'phone' => '081234567890',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'name' => 'Updated Name',
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_user_can_get_me(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/me');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'email' => $user->email,
            ]
        ]);
    }

    public function test_user_can_refresh_token(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/refresh');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'token',
                'token_type',
                'expires_in'
            ]
        ]);
    }

    public function test_unauthenticated_user_cannot_access_protected_routes(): void
    {
        $getRoutes = [
            '/api/profile' => 401,
            '/api/me' => 401,
            '/api/antrianmu' => 401,
        ];

        foreach ($getRoutes as $route => $expectedStatus) {
            $response = $this->getJson($route);
            $this->assertEquals(
                $expectedStatus,
                $response->status(),
                "Route {$route} expected {$expectedStatus} but got {$response->status()}"
            );
        }

        $postRoutes = [
            '/api/logout' => 401,
        ];

        foreach ($postRoutes as $route => $expectedStatus) {
            $response = $this->postJson($route);
            $this->assertEquals(
                $expectedStatus,
                $response->status(),
                "Route {$route} expected {$expectedStatus} but got {$response->status()}"
            );
        }
    }

    public function test_admin_login_redirects_to_admin_dashboard_json(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'user' => [
                    'role' => 'admin',
                ]
            ]
        ]);
    }

    public function test_dokter_login_has_poli_spesialisasi(): void
    {
        $user = User::factory()->create([
            'email' => 'dokter@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::DOKTER,
            'poli_spesialisasi' => 'Umum',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'dokter@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => [
                'user' => [
                    'role' => 'dokter',
                    'poli' => 'Umum',
                ]
            ]
        ]);
    }

    public function test_user_can_login_with_role_filter(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    public function test_user_cannot_login_with_wrong_role(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::USER,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertStatus(403);
        $response->assertJson(['success' => false]);
    }
}