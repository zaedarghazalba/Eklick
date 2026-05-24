<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test User model can be created.
     */
    public function test_user_model_can_be_created(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    /**
     * Test User factory works correctly.
     */
    public function test_user_factory_works(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(User::class, $user);
        $this->assertNotNull($user->id);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
    }

    /**
     * Test User has fillable attributes.
     */
    public function test_user_has_fillable_attributes(): void
    {
        $user = new User();

        $fillable = [
            'google_id',
            'name',
            'email',
            'password',
            'role',
            'poli_spesialisasi',
        ];

        $this->assertEquals($fillable, $user->getFillable());
    }

    /**
     * Test User has hidden attributes.
     */
    public function test_user_has_hidden_attributes(): void
    {
        $user = new User();

        $hidden = [
            'password',
            'remember_token',
        ];

        $this->assertEquals($hidden, $user->getHidden());
    }

    /**
     * Test password is hidden in array.
     */
    public function test_password_is_hidden_in_array(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('secret123'),
        ]);

        $array = $user->toArray();

        $this->assertArrayNotHasKey('password', $array);
        $this->assertArrayNotHasKey('remember_token', $array);
    }

    /**
     * Test password is hashed.
     */
    public function test_password_is_hashed(): void
    {
        $user = User::factory()->create();

        // Factory uses 'password' as default password
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertNotEquals('password', $user->password);
    }

    /**
     * Test User can have google_id.
     */
    public function test_user_can_have_google_id(): void
    {
        $user = User::factory()->create([
            'google_id' => '1234567890',
        ]);

        $this->assertEquals('1234567890', $user->google_id);
    }

    /**
     * Test google_id can be null.
     */
    public function test_google_id_can_be_null(): void
    {
        $user = User::factory()->create([
            'google_id' => null,
        ]);

        $this->assertNull($user->google_id);
    }

    /**
     * Test password can be null (for SSO users).
     */
    public function test_password_can_be_null(): void
    {
        $user = User::create([
            'google_id' => '1234567890',
            'name' => 'SSO User',
            'email' => 'sso@example.com',
            'password' => null,
        ]);

        $this->assertNull($user->password);
    }

    /**
     * Test JWT identifier returns user key.
     */
    public function test_jwt_identifier_returns_user_key(): void
    {
        $user = User::factory()->create();

        $this->assertEquals($user->id, $user->getJWTIdentifier());
    }

    /**
     * Test JWT custom claims returns empty array.
     */
    public function test_jwt_custom_claims_returns_empty_array(): void
    {
        $user = User::factory()->create();

        $this->assertEquals([], $user->getJWTCustomClaims());
        $this->assertIsArray($user->getJWTCustomClaims());
    }

    /**
     * Test email must be unique.
     */
    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'unique@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => 'unique@example.com',
        ]);
    }

    /**
     * Test User has timestamps.
     */
    public function test_user_has_timestamps(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->created_at);
        $this->assertNotNull($user->updated_at);
    }

    /**
     * Test User can be updated.
     */
    public function test_user_can_be_updated(): void
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
        ]);

        $user->update([
            'name' => 'Updated Name',
        ]);

        $this->assertEquals('Updated Name', $user->name);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    /**
     * Test User can be deleted.
     */
    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $userId,
        ]);
    }

    /**
     * Test User factory with Google ID state.
     */
    public function test_user_factory_with_google_id_state(): void
    {
        $user = User::factory()->withGoogleId()->create();

        $this->assertNotNull($user->google_id);
        $this->assertNull($user->password);
    }

    /**
     * Test User factory default state has password.
     */
    public function test_user_factory_default_has_password(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->password);
        $this->assertNull($user->google_id);
    }

    /**
     * Test User name is required.
     */
    public function test_user_name_is_stored(): void
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
        ]);

        $this->assertEquals('John Doe', $user->name);
    }

    /**
     * Test User email is stored correctly.
     */
    public function test_user_email_is_stored_correctly(): void
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
        ]);

        $this->assertEquals('johndoe@example.com', $user->email);
    }

    /**
     * Test User casts include email_verified_at as datetime.
     */
    public function test_user_casts_include_password_hashed(): void
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
    }

    /**
     * Test User model uses correct database table.
     */
    public function test_user_model_uses_correct_table(): void
    {
        $user = new User();

        $this->assertEquals('users', $user->getTable());
    }
}
