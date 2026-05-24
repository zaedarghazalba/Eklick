<?php

namespace Tests\Unit;

use App\Models\Antrians;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AntrianModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Antrians model can be created.
     */
    public function test_antrians_model_can_be_created(): void
    {
        $user = User::factory()->create();

        $antrian = Antrians::create([
            'poli' => 'Umum',
            'tanggal_daftar' => '2024-12-25',
            'nama' => 'Test Patient',
            'no_ktp' => '1234567890123456',
            'alamat' => 'Jl. Test No. 123',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '08123456789',
            'tgl_lahir' => '1990-01-01',
            'pekerjaan' => 'Developer',
            'rekam_medis' => null,
            'no_antrian' => 1,
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Antrians::class, $antrian);
        $this->assertEquals('Umum', $antrian->poli);
        $this->assertEquals('Test Patient', $antrian->nama);
        $this->assertEquals($user->id, $antrian->user_id);
    }

    /**
     * Test Antrians factory works correctly.
     */
    public function test_antrians_factory_works(): void
    {
        $antrian = Antrians::factory()->create();

        $this->assertInstanceOf(Antrians::class, $antrian);
        $this->assertNotNull($antrian->id);
        $this->assertNotNull($antrian->poli);
        $this->assertNotNull($antrian->nama);
        $this->assertNotNull($antrian->user_id);
    }

    /**
     * Test Antrians factory with specific poli.
     */
    public function test_antrians_factory_with_specific_poli(): void
    {
        $antrian = Antrians::factory()->poli('Mata')->create();

        $this->assertEquals('Mata', $antrian->poli);
    }

    /**
     * Test Antrians factory with medical record.
     */
    public function test_antrians_factory_with_medical_record(): void
    {
        $antrian = Antrians::factory()->withMedicalRecord()->create();

        $this->assertNotNull($antrian->rekam_medis);
        $this->assertStringContainsString('rekam_medis/', $antrian->rekam_medis);
    }

    /**
     * Test Antrians has all fillable attributes.
     */
    public function test_antrians_has_fillable_attributes(): void
    {
        $antrian = new Antrians();

        $fillable = [
            'poli',
            'tanggal_daftar',
            'nama',
            'no_ktp',
            'alamat',
            'jenis_kelamin',
            'no_hp',
            'tgl_lahir',
            'pekerjaan',
            'rekam_medis',
            'user_id',
            'dokter_id', // NEW: Foreign key to dokter
            'no_antrian',
            'status',
            'skipped',
            'dipanggil_at',
            'diagnosa',
            'catatan_dokter',
            'resep_obat',
            'tanggal_periksa',
            // Vital Signs
            'tekanan_darah',
            'suhu_tubuh',
            'nadi',
            'tinggi_badan',
            'berat_badan',
            // Examination
            'keluhan_utama',
            'riwayat_penyakit',
            'pemeriksaan_fisik',
            'hasil_lab',
            // Medical Files
            'foto_pemeriksaan',
            'foto_rontgen',
            'file_pendukung',
            // Treatment
            'tindakan_medis',
            'anjuran',
            // Doctor Info (kept for backward compatibility)
            'nama_dokter',
            'dokter_poli'
        ];

        $this->assertEquals($fillable, $antrian->getFillable());
    }

    /**
     * Test Antrians has timestamps.
     */
    public function test_antrians_has_timestamps(): void
    {
        $antrian = Antrians::factory()->create();

        $this->assertNotNull($antrian->created_at);
        $this->assertNotNull($antrian->updated_at);
    }

    /**
     * Test Antrians can be updated.
     */
    public function test_antrians_can_be_updated(): void
    {
        $antrian = Antrians::factory()->create([
            'nama' => 'Original Name',
        ]);

        $antrian->update([
            'nama' => 'Updated Name',
        ]);

        $this->assertEquals('Updated Name', $antrian->nama);
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'nama' => 'Updated Name',
        ]);
    }

    /**
     * Test Antrians can be soft deleted.
     */
    public function test_antrians_can_be_deleted(): void
    {
        $antrian = Antrians::factory()->create();
        $antrianId = $antrian->id;

        $antrian->delete();

        // With soft deletes, data is not actually removed from database
        // Instead, it's marked with deleted_at timestamp
        $this->assertSoftDeleted('antrians', [
            'id' => $antrianId,
        ]);

        // Data should not appear in normal queries
        $this->assertNull(Antrians::find($antrianId));

        // But should be available with withTrashed()
        $this->assertNotNull(Antrians::withTrashed()->find($antrianId));
    }

    /**
     * Test poli can only be specific values.
     */
    public function test_poli_values_are_valid(): void
    {
        $validPoliValues = ['Umum', 'Mata', 'THT', 'Ibu Dan Anak'];

        foreach ($validPoliValues as $poli) {
            $antrian = Antrians::factory()->create(['poli' => $poli]);
            $this->assertEquals($poli, $antrian->poli);
        }
    }

    /**
     * Test no_ktp is stored correctly.
     */
    public function test_no_ktp_is_stored_correctly(): void
    {
        $antrian = Antrians::factory()->create([
            'no_ktp' => '3201234567890123',
        ]);

        $this->assertEquals('3201234567890123', $antrian->no_ktp);
        $this->assertEquals(16, strlen($antrian->no_ktp));
    }

    /**
     * Test jenis_kelamin values.
     */
    public function test_jenis_kelamin_values(): void
    {
        $antrianLaki = Antrians::factory()->create(['jenis_kelamin' => 'Laki-laki']);
        $antrianPerempuan = Antrians::factory()->create(['jenis_kelamin' => 'Perempuan']);

        $this->assertEquals('Laki-laki', $antrianLaki->jenis_kelamin);
        $this->assertEquals('Perempuan', $antrianPerempuan->jenis_kelamin);
    }

    /**
     * Test rekam_medis can be null.
     */
    public function test_rekam_medis_can_be_null(): void
    {
        $antrian = Antrians::factory()->create(['rekam_medis' => null]);

        $this->assertNull($antrian->rekam_medis);
    }

    /**
     * Test no_antrian is stored correctly.
     */
    public function test_no_antrian_is_stored_correctly(): void
    {
        $antrian = Antrians::factory()->create(['no_antrian' => 42]);

        $this->assertEquals(42, $antrian->no_antrian);
        $this->assertIsInt($antrian->no_antrian);
    }

    /**
     * Test multiple antrians can exist for same user.
     */
    public function test_multiple_antrians_can_exist_for_same_user(): void
    {
        $user = User::factory()->create();

        Antrians::factory()->count(3)->create(['user_id' => $user->id]);

        $antrians = Antrians::where('user_id', $user->id)->get();

        $this->assertCount(3, $antrians);
    }

    /**
     * Test antrians are ordered by creation date.
     */
    public function test_antrians_can_be_ordered_by_created_at(): void
    {
        Antrians::factory()->create(['created_at' => now()->subDays(2)]);
        Antrians::factory()->create(['created_at' => now()->subDays(1)]);
        Antrians::factory()->create(['created_at' => now()]);

        $antrians = Antrians::orderBy('created_at', 'asc')->get();

        $this->assertTrue($antrians[0]->created_at < $antrians[1]->created_at);
        $this->assertTrue($antrians[1]->created_at < $antrians[2]->created_at);
    }
}
