<?php

namespace Database\Factories;

use App\Models\Antrians;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrians>
 */
class AntrianFactory extends Factory
{
    protected $model = Antrians::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'poli' => fake()->randomElement(['Umum', 'Mata', 'THT', 'Ibu Dan Anak']),
            'tanggal_daftar' => fake()->date(),
            'nama' => fake()->name(),
            'no_ktp' => fake()->numerify('################'), // 16 digit KTP
            'alamat' => fake()->address(),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'no_hp' => fake()->numerify('08##########'), // Format nomor HP Indonesia
            'tgl_lahir' => fake()->date(),
            'pekerjaan' => fake()->jobTitle(),
            'rekam_medis' => null,
            'no_antrian' => fake()->numberBetween(1, 100),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate that the antrian has a medical record file.
     */
    public function withMedicalRecord(): static
    {
        return $this->state(fn (array $attributes) => [
            'rekam_medis' => 'rekam_medis/test_file.pdf',
        ]);
    }

    /**
     * Indicate specific poli for the antrian.
     */
    public function poli(string $poli): static
    {
        return $this->state(fn (array $attributes) => [
            'poli' => $poli,
        ]);
    }

    /**
     * Set specific registration date.
     */
    public function registrationDate(string $date): static
    {
        return $this->state(fn (array $attributes) => [
            'tanggal_daftar' => $date,
        ]);
    }
}
