<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user has a Google ID (SSO user).
     */
    public function withGoogleId(): static
    {
        return $this->state(fn (array $attributes) => [
            'google_id' => fake()->numerify('####################'),
            'password' => null, // SSO users don't need password
        ]);
    }

    /**
     * Indicate that the user is a doctor.
     */
    public function dokter(?string $poli = null): static
    {
        $poliOptions = ['Umum', 'Mata', 'THT', 'Ibu Dan Anak'];

        return $this->state(fn (array $attributes) => [
            'role' => 'dokter',
            'poli_spesialisasi' => $poli ?? fake()->randomElement($poliOptions),
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'poli_spesialisasi' => null,
        ]);
    }
}
