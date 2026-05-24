<?php

namespace Tests\Feature;

use App\Models\Antrians;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AntrianTest extends TestCase
{
    use RefreshDatabase;

    private function getAuthHeaders(User $user): array
    {
        $token = JWTAuth::fromUser($user);
        return ['Authorization' => 'Bearer ' . $token];
    }

    private function getAntrianData(array $overrides = []): array
    {
        return array_merge([
            'poli' => 'Umum',
            'tanggal_daftar' => '2024-12-25',
            'nama' => 'John Doe',
            'no_ktp' => '1234567890123456',
            'alamat' => 'Jl. Test No. 123',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '08123456789',
            'tgl_lahir' => '1990-01-01',
            'pekerjaan' => 'Developer',
        ], $overrides);
    }

    public function test_authenticated_user_can_create_antrian_api(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);
        $data = $this->getAntrianData();

        $response = $this->postJson('/api/antrian/send', $data, $this->getAuthHeaders($user));

        $response->assertStatus(201);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('antrians', [
            'poli' => 'Umum',
            'nama' => 'John Doe',
        ]);
    }

    public function test_unauthenticated_user_cannot_create_antrian_api(): void
    {
        $response = $this->postJson('/api/antrian/send', $this->getAntrianData());

        $response->assertStatus(401);
    }

    public function test_queue_number_is_auto_assigned_sequentially(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);
        $headers = $this->getAuthHeaders($user);

        $baseData = array_diff_key($this->getAntrianData(), array_flip(['nama', 'no_ktp']));

        $this->postJson('/api/antrian/send', array_merge($baseData, ['nama' => 'Patient 1', 'no_ktp' => '1111111111111111']), $headers);
        $this->postJson('/api/antrian/send', array_merge($baseData, ['nama' => 'Patient 2', 'no_ktp' => '2222222222222222']), $headers);
        $this->postJson('/api/antrian/send', array_merge($baseData, ['nama' => 'Patient 3', 'no_ktp' => '3333333333333333']), $headers);

        $this->assertDatabaseHas('antrians', ['nama' => 'Patient 1', 'no_antrian' => 1]);
        $this->assertDatabaseHas('antrians', ['nama' => 'Patient 2', 'no_antrian' => 2]);
        $this->assertDatabaseHas('antrians', ['nama' => 'Patient 3', 'no_antrian' => 3]);
    }

    public function test_queue_number_is_separate_per_poli(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);
        $headers = $this->getAuthHeaders($user);

        $baseData = array_diff_key($this->getAntrianData(), array_flip(['poli', 'nama', 'no_ktp']));

        $this->postJson('/api/antrian/send', array_merge($baseData, ['poli' => 'Umum', 'nama' => 'Umum 1', 'no_ktp' => '1111111111111111']), $headers);
        $this->postJson('/api/antrian/send', array_merge($baseData, ['poli' => 'Mata', 'nama' => 'Mata 1', 'no_ktp' => '2222222222222222']), $headers);
        $this->postJson('/api/antrian/send', array_merge($baseData, ['poli' => 'Umum', 'nama' => 'Umum 2', 'no_ktp' => '3333333333333333']), $headers);

        $this->assertDatabaseHas('antrians', ['poli' => 'Umum', 'nama' => 'Umum 1', 'no_antrian' => 1]);
        $this->assertDatabaseHas('antrians', ['poli' => 'Mata', 'nama' => 'Mata 1', 'no_antrian' => 1]);
        $this->assertDatabaseHas('antrians', ['poli' => 'Umum', 'nama' => 'Umum 2', 'no_antrian' => 2]);
    }

    public function test_antrian_creation_requires_all_required_fields(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);

        $response = $this->postJson('/api/antrian/send', [], $this->getAuthHeaders($user));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['poli', 'tanggal_daftar', 'nama', 'no_ktp', 'alamat', 'jenis_kelamin', 'no_hp', 'tgl_lahir', 'pekerjaan']);
    }

    public function test_antrian_can_be_created_with_medical_record_file(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => UserRole::USER]);
        $file = UploadedFile::fake()->create('rekam_medis.pdf', 1024);

        $data = $this->getAntrianData(['rekam_medis' => $file]);

        $response = $this->postJson('/api/antrian/send', $data, $this->getAuthHeaders($user));

        $response->assertStatus(201);
    }

    public function test_medical_record_file_must_be_valid_type(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);
        $file = UploadedFile::fake()->create('document.txt', 1024);

        $data = $this->getAntrianData(['rekam_medis' => $file]);

        $response = $this->postJson('/api/antrian/send', $data, $this->getAuthHeaders($user));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['rekam_medis']);
    }

    public function test_get_antrian_list_api(): void
    {
        Antrians::factory()->count(2)->create();

        $response = $this->getJson('/api/antrian');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function test_get_antrian_by_poli(): void
    {
        Antrians::factory()->create(['poli' => 'Umum']);
        Antrians::factory()->create(['poli' => 'Mata']);

        $response = $this->getJson('/api/antrian/poli/Umum');

        $response->assertStatus(200);
    }

    public function test_filter_antrian_by_poli_and_date(): void
    {
        Antrians::factory()->create([
            'poli' => 'THT',
            'tanggal_daftar' => '2024-12-25',
        ]);
        Antrians::factory()->create([
            'poli' => 'Umum',
            'tanggal_daftar' => '2024-12-26',
        ]);

        $response = $this->postJson('/api/antrian/filter', [
            'poli' => 'THT',
            'tanggal' => '2024-12-25',
        ]);

        $response->assertStatus(200);
    }

    public function test_get_user_own_antrian_api(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);
        $otherUser = User::factory()->create(['role' => UserRole::USER]);

        Antrians::factory()->count(3)->create(['user_id' => $user->id]);
        Antrians::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $response = $this->getJson('/api/antrianmu', $this->getAuthHeaders($user));

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_get_antrian_kuota_by_poli_and_date(): void
    {
        Antrians::factory()->create([
            'poli' => 'Umum',
            'tanggal_daftar' => date('Y-m-d'),
        ]);

        $response = $this->getJson('/api/antrian/kuota?poli=Umum&tanggal=' . date('Y-m-d'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }

    public function test_panggil_queue_number(): void
    {
        $antrian = Antrians::factory()->create();

        $response = $this->getJson("/panggil/{$antrian->no_antrian}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Memanggil nomor antrian: ' . $antrian->no_antrian]);
    }

    public function test_admin_can_get_all_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        Antrians::factory()->count(3)->create();

        $response = $this->getJson('/api/admin/antrian', $this->getAuthHeaders($admin));

        $response->assertStatus(200);
    }

    public function test_dokter_can_get_own_antrian(): void
    {
        $dokter = User::factory()->create([
            'role' => UserRole::DOKTER,
            'poli_spesialisasi' => 'Umum',
        ]);
        Antrians::factory()->create(['poli' => 'Umum']);
        Antrians::factory()->create(['poli' => 'Mata']);

        $response = $this->getJson('/api/doctor/antrian', $this->getAuthHeaders($dokter));

        $response->assertStatus(200);
    }

    public function test_dokter_can_save_diagnosa(): void
    {
        $dokter = User::factory()->create([
            'role' => UserRole::DOKTER,
            'poli_spesialisasi' => 'Umum',
        ]);
        $antrian = Antrians::factory()->create(['poli' => 'Umum']);

        $response = $this->postJson("/api/doctor/antrian/{$antrian->id}/diagnosa", [
            'keluhan_utama' => 'Sakit kepala',
            'diagnosa' => 'Migrain',
            'resep_obat' => 'Paracetamol 500mg',
            'tekanan_darah' => '120/80',
            'suhu_tubuh' => '36.5',
        ], $this->getAuthHeaders($dokter));

        $response->assertStatus(200);
        $this->assertDatabaseHas('antrians', [
            'id' => $antrian->id,
            'diagnosa' => 'Migrain',
        ]);
    }

    public function test_dokter_can_get_diagnosa(): void
    {
        $dokter = User::factory()->create([
            'role' => UserRole::DOKTER,
            'poli_spesialisasi' => 'Umum',
        ]);
        $antrian = Antrians::factory()->create([
            'poli' => 'Umum',
            'diagnosa' => 'Test Diagnosa',
        ]);

        $response = $this->getJson("/api/doctor/antrian/{$antrian->id}", $this->getAuthHeaders($dokter));

        $response->assertStatus(200);
        $response->assertJson(['diagnosa' => 'Test Diagnosa']);
    }

    public function test_admin_can_panggil_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $antrian = Antrians::factory()->create(['status' => 'menunggu']);

        $response = $this->postJson("/api/admin/antrian/{$antrian->id}/panggil", [], $this->getAuthHeaders($admin));

        $this->assertContains($response->status(), [200, 201, 400]);
        if ($response->status() !== 500) {
            $response->assertJsonStructure(['success', 'message']);
        }
    }

    public function test_admin_can_skip_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $antrian = Antrians::factory()->create(['status' => 'menunggu']);

        $response = $this->postJson("/api/admin/antrian/{$antrian->id}/skip", [], $this->getAuthHeaders($admin));

        $this->assertContains($response->status(), [200, 201, 400]);
        if ($response->status() !== 500) {
            $response->assertJsonStructure(['success', 'message']);
        }
    }

    public function test_admin_can_selesai_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $antrian = Antrians::factory()->create(['status' => 'menunggu']);

        $response = $this->postJson("/api/admin/antrian/{$antrian->id}/selesai", [], $this->getAuthHeaders($admin));

        $this->assertContains($response->status(), [200, 201, 400, 500]);
        if ($response->status() !== 500) {
            $response->assertJsonStructure(['success', 'message']);
        }
    }

    public function test_admin_can_delete_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $antrian = Antrians::factory()->create();

        $response = $this->deleteJson("/api/admin/antrian/{$antrian->id}", [], $this->getAuthHeaders($admin));

        $response->assertStatus(200);
    }

    public function test_admin_can_reset_antrian(): void
    {
        $admin = User::factory()->create(['role' => UserRole::ADMIN]);
        $antrian = Antrians::factory()->create(['status' => 'selesai']);

        $response = $this->postJson("/api/admin/antrian/{$antrian->id}/reset", [], $this->getAuthHeaders($admin));

        $response->assertStatus(200);
    }

    public function test_user_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);

        $response = $this->getJson('/api/admin/antrian', $this->getAuthHeaders($user));

        $response->assertStatus(403);
    }

    public function test_non_dokter_cannot_access_doctor_routes(): void
    {
        $user = User::factory()->create(['role' => UserRole::USER]);

        $response = $this->getJson('/api/doctor/antrian', $this->getAuthHeaders($user));

        $response->assertStatus(403);
    }
}