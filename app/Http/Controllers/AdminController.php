<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Antrians;
use App\Enums\UserRole;
use App\Services\DashboardService;
use App\Services\AntrianService;
use App\Helpers\JsonResponse;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\StoreDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected DashboardService $dashboardService;
    protected AntrianService $antrianService;

    public function __construct(DashboardService $dashboardService, AntrianService $antrianService)
    {
        $this->dashboardService = $dashboardService;
        $this->antrianService = $antrianService;
    }

    public function dashboard()
    {
        $user = auth()->user();
        $data = $this->dashboardService->getStatistics();
        $data['admin'] = $user;

        return view('admin.dashboard', $data);
    }

    public function users()
    {
        $users = User::where('role', UserRole::USER)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function deleteUser(int $id)
    {
        try {
            $user = User::findOrFail($id);

            if ($user->role === UserRole::ADMIN) {
                return JsonResponse::error('Tidak dapat menghapus admin!', 403);
            }

            $user->delete();

            Log::info('User deleted', ['user_id' => $id]);

            return JsonResponse::success('User berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting user', ['user_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error('Terjadi kesalahan saat menghapus user.', 500);
        }
    }

    public function doctors()
    {
        $doctors = User::where('role', UserRole::DOKTER)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.doctors', compact('doctors'));
    }

    public function createDoctor()
    {
        return view('admin.create-doctor');
    }

    public function storeDoctor(StoreDoctorRequest $request)
    {
        try {
            $doctor = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => UserRole::DOKTER,
                'poli_spesialisasi' => $request->poli_spesialisasi,
            ]);

            Log::info('Doctor created', ['doctor_id' => $doctor->id]);

            return redirect()->route('admin.doctors')->with('success', 'Akun dokter berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error creating doctor', ['error' => $e->getMessage()]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun dokter.'])->withInput();
        }
    }

    public function editDoctor(int $id)
    {
        $doctor = User::where('role', UserRole::DOKTER)->findOrFail($id);

        return view('admin.edit-doctor', compact('doctor'));
    }

    public function updateDoctor(UpdateDoctorRequest $request, int $id)
    {
        try {
            $doctor = User::where('role', UserRole::DOKTER)->findOrFail($id);

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'poli_spesialisasi' => $request->poli_spesialisasi,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $doctor->update($data);

            Log::info('Doctor updated', ['doctor_id' => $id]);

            return redirect()->route('admin.doctors')->with('success', 'Data dokter berhasil diupdate!');
        } catch (\Exception $e) {
            Log::error('Error updating doctor', ['doctor_id' => $id, 'error' => $e->getMessage()]);

            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate dokter.'])->withInput();
        }
    }

    public function deleteDoctor(int $id)
    {
        try {
            $doctor = User::where('role', UserRole::DOKTER)->findOrFail($id);
            $doctor->delete();

            Log::info('Doctor deleted', ['doctor_id' => $id]);

            return JsonResponse::success('Dokter berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting doctor', ['doctor_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error('Terjadi kesalahan saat menghapus dokter.', 500);
        }
    }

    public function antrian(Request $request)
    {
        $query = Antrians::with('user');
        $this->applyAntrianFilters($query, $request);

        $antrian = $query->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return view('admin.antrian', compact('antrian'));
    }

    public function panggilAntrian(int $id)
    {
        try {
            $antrian = $this->antrianService->panggilAntrian($id);

            return JsonResponse::success('Antrian berhasil dipanggil!', $antrian);
        } catch (\Exception $e) {
            Log::error('Error calling antrian', ['antrian_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error($e->getMessage(), 400);
        }
    }

    public function skipAntrian(int $id)
    {
        try {
            $antrian = $this->antrianService->skipAntrian($id);

            return JsonResponse::success('Antrian berhasil di-skip!', $antrian);
        } catch (\Exception $e) {
            Log::error('Error skipping antrian', ['antrian_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error($e->getMessage(), 400);
        }
    }

    public function selesaiAntrian(int $id)
    {
        try {
            $antrian = $this->antrianService->selesaiAntrian($id);

            return JsonResponse::success('Antrian berhasil diselesaikan!', $antrian);
        } catch (\Exception $e) {
            Log::error('Error completing antrian', ['antrian_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error('Terjadi kesalahan saat menyelesaikan antrian.', 500);
        }
    }

    public function resetAntrian(int $id)
    {
        try {
            $antrian = $this->antrianService->resetAntrian($id);

            return JsonResponse::success('Status antrian berhasil direset!', $antrian);
        } catch (\Exception $e) {
            Log::error('Error resetting antrian', ['antrian_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error('Terjadi kesalahan saat mereset antrian.', 500);
        }
    }

    public function deleteAntrian(int $id)
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->delete();

            Log::info('Antrian deleted', ['antrian_id' => $id]);

            return JsonResponse::success('Antrian berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting antrian', ['antrian_id' => $id, 'error' => $e->getMessage()]);

            return JsonResponse::error('Terjadi kesalahan saat menghapus antrian.', 500);
        }
    }

    public function getAntrian(int $id)
    {
        try {
            $antrian = Antrians::with('user')->findOrFail($id);

            return JsonResponse::success('Data antrian ditemukan.', $antrian);
        } catch (\Exception $e) {
            return JsonResponse::error('Antrian tidak ditemukan.', 404);
        }
    }

    public function dataPasien(Request $request)
    {
        $query = Antrians::with('user')->whereNotNull('diagnosa');
        $this->applyPasienFilters($query, $request);

        $showCompleted = $request->get('show_completed', false);
        if (!$showCompleted) {
            $query->whereNotIn('status', ['selesai', 'skip']);
        } else {
            $query->where(function($q) {
                $q->whereNotIn('status', ['selesai', 'skip'])
                  ->orWhere(function($q2) {
                      $q2->whereIn('status', ['selesai', 'skip'])
                         ->where('updated_at', '>=', now()->subDays(1));
                  });
            });
        }

        $pasien = $query->orderBy('tanggal_periksa', 'desc')->get();

        return view('admin.data-pasien', compact('pasien', 'showCompleted'));
    }

    public function dataPasienArchive(Request $request)
    {
        $query = Antrians::with('user')
            ->whereNotNull('diagnosa')
            ->whereIn('status', ['selesai', 'skip'])
            ->where('updated_at', '<', now()->subDays(1));

        $this->applyPasienFilters($query, $request);

        $archived = $query->orderBy('updated_at', 'desc')->get();

        return view('admin.data-pasien-archive', compact('archived'));
    }

    private function applyAntrianFilters($query, Request $request): void
    {
        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_daftar', $request->tanggal);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    }

    private function applyPasienFilters($query, Request $request): void
    {
        if ($request->filled('poli')) {
            $query->where('poli', $request->poli);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_periksa', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_periksa', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
    }
}