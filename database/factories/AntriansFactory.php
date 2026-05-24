<?php

namespace Database\Factories;

use App\Models\Antrians;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Antrians>
 */
class AntriansFactory extends Factory
{
    protected $model = Antrians::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $poli = fake()->randomElement(['Umum', 'Mata', 'THT', 'Ibu Dan Anak']);
        $tanggalDaftar = fake()->date();

        // Calculate next queue number for this poli and date
        $maxNoAntrian = Antrians::where('poli', $poli)
            ->where('tanggal_daftar', $tanggalDaftar)
            ->max('no_antrian');

        $noAntrian = $maxNoAntrian ? $maxNoAntrian + 1 : 1;

        return [
            'poli' => $poli,
            'tanggal_daftar' => $tanggalDaftar,
            'nama' => fake()->name(),
            'no_ktp' => fake()->numerify('################'), // 16 digit KTP
            'alamat' => fake()->address(),
            'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
            'no_hp' => fake()->numerify('08##########'), // Format nomor HP Indonesia
            'tgl_lahir' => fake()->date(),
            'pekerjaan' => fake()->jobTitle(),
            'rekam_medis' => null,
            'no_antrian' => $noAntrian,
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
        return $this->state(function (array $attributes) use ($poli) {
            // Recalculate no_antrian for this poli and date
            $maxNoAntrian = Antrians::where('poli', $poli)
                ->where('tanggal_daftar', $attributes['tanggal_daftar'])
                ->max('no_antrian');

            return [
                'poli' => $poli,
                'no_antrian' => $maxNoAntrian ? $maxNoAntrian + 1 : 1,
            ];
        });
    }

    /**
     * Set specific registration date.
     */
    public function registrationDate(string $date): static
    {
        return $this->state(function (array $attributes) use ($date) {
            // Recalculate no_antrian for this date and poli
            $maxNoAntrian = Antrians::where('poli', $attributes['poli'])
                ->where('tanggal_daftar', $date)
                ->max('no_antrian');

            return [
                'tanggal_daftar' => $date,
                'no_antrian' => $maxNoAntrian ? $maxNoAntrian + 1 : 1,
            ];
        });
    }
}
