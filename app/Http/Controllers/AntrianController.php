<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Facades\JWTAuth; // Import kelas JWTAuth
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\Models\Antrians;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AntrianController extends Controller
{
    /**
     * Menyimpan data antrian baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Log data request yang diterima
        Log::info('Request data received: ', $request->all());

        // Validasi data request
        $validatedData = $this->validateRequest($request);

        // Handle file upload (jika ada)
        $validatedData['rekam_medis'] = $this->handleFileUpload($request);

        try {
            // Cek apakah permintaan berasal dari Web atau API
            if ($request->is('api/*')) {
                // Jika permintaan datang dari API, kita akan menggunakan JWT
                $token = $request->bearerToken(); // Mengambil token dari header Authorization

                // Log token yang diterima
                Log::info('Received token: ' . $token);

                // Cek jika token tidak ditemukan
                if (!$token) {
                    Log::error('Token not found in the request');
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Token tidak ditemukan',
                    ], 401);
                }

                // Verifikasi token dan ambil data user
                $user = JWTAuth::parseToken()->authenticate();

                // Jika token tidak valid atau user tidak ditemukan
                if (!$user) {
                    Log::error('User not authenticated', ['token' => $token]);
                    return response()->json([
                        'status' => 'error',
                        'message' => 'User not authenticated',
                    ], 401);
                }
            } else {
                // Jika permintaan datang dari Web (misalnya melalui session)
                if (!session()->has('user_id')) {
                    Log::error('User not authenticated');
                    return redirect()->route('googlesso')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
                }

                // Ambil user dari session
                $user = User::find(session('user_id'));

                // Jika user tidak ditemukan
                if (!$user) {
                    Log::error('User not found in session', ['user_id' => session('user_id')]);
                    return redirect()->route('googlesso')->withErrors(['error' => 'User tidak ditemukan. Silakan login kembali.']);
                }
            }
        } catch (\Exception $e) {
            // Log exception error untuk authentication
            Log::error('Authentication error: ' . $e->getMessage(), ['exception' => $e]);

            // Cek apakah request dari API atau Web
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to authenticate user',
                    'details' => $e->getMessage(),
                ], 500);
            } else {
                return redirect()->route('googlesso')->withErrors(['error' => 'Terjadi kesalahan autentikasi.']);
            }
        }

        // Set data user_id
        $validatedData['user_id'] = $user->id;

        try {
            // Use database transaction to prevent race condition
            $antrian = DB::transaction(function () use ($validatedData) {
                // Lock table to prevent concurrent access
                // Ambil nomor antrian terbesar untuk poli dan tanggal yang sama dengan lock
                $maxNoAntrian = Antrians::where('poli', $validatedData['poli'])
                    ->where('tanggal_daftar', $validatedData['tanggal_daftar'])
                    ->lockForUpdate() // Prevent concurrent reads
                    ->max('no_antrian');

                // Tentukan nomor antrian berdasarkan nomor terbesar + 1 (atau 1 jika belum ada)
                $validatedData['no_antrian'] = $maxNoAntrian ? $maxNoAntrian + 1 : 1;

                // Simpan data antrian ke database, termasuk no_antrian
                return Antrians::create($validatedData);
            });

            // Cek apakah request dari API atau Web
            if ($request->is('api/*') || $request->expectsJson()) {
                // Kembalikan JSON response untuk API
                return response()->json([
                    'status' => 'success',
                    'message' => 'Antrian berhasil disimpan.',
                    'data' => $antrian,
                ], 201);  // Status 201 Created
            } else {
                // Redirect untuk Web dengan flash message
                return redirect()->route('home')->with('success', 'Antrian berhasil didaftarkan! Nomor antrian Anda: ' . $antrian->no_antrian);
            }
        } catch (\Exception $e) {
            // Log error saat terjadi masalah saat penyimpanan
            Log::error('Error saving antrian: ' . $e->getMessage(), ['exception' => $e, 'data' => $validatedData]);

            // Cek apakah request dari API atau Web
            if ($request->is('api/*') || $request->expectsJson()) {
                // Kembalikan JSON response error untuk API
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan saat menyimpan antrian.',
                    'details' => $e->getMessage(),
                ], 500);  // Status 500 Internal Server Error
            } else {
                // Redirect untuk Web dengan error message
                return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan antrian.'])->withInput();
            }
        }
    }



    /**
     * Validasi data request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'poli' => 'required',
            'tanggal_daftar' => 'required',
            'nama' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required',
            'rekam_medis' => 'nullable|file|mimes:pdf,doc,docx',
            'no_antrian' => 'nullable',
        ]);
    }




    /**
     * Handle file upload if rekam medis is provided.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    private function handleFileUpload(Request $request)
    {
        if ($request->hasFile('rekam_medis')) {
            $file = $request->file('rekam_medis');
            return $file->store('rekam_medis', 'public');
        }
        return null; // No file uploaded
    }

    

    /**
     * Menampilkan semua data antrian.
     *
     * @return \Illuminate\Http\Response
     */
    public function daftar()
    {
        // Cek apakah request ingin JSON (API) atau view (Web)
        if (request()->expectsJson() || request()->is('api/*')) {
            $antriannya = Antrians::orderBy('tanggal_daftar', 'desc')
                ->orderBy('no_antrian', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Daftar antrian ditemukan.',
                'data' => $antriannya
            ], 200);
        }

        // Mengirimkan data antrian ke view antrian untuk Web
        $antriannya = Antrians::all();
        return view('patient.antrian', ['antrian' => $antriannya]);
    }

    public function daftarAPI(Request $request)
    {
        $query = Antrians::query();

        // Filter by poli if provided
        if ($request->has('poli') && $request->poli) {
            $query->where('poli', $request->poli);
        }

        // Filter by tanggal if provided
        if ($request->has('tanggal') && $request->tanggal) {
            $query->whereDate('tanggal_daftar', $request->tanggal);
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $antriannya = $query->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar antrian ditemukan.',
            'data' => $antriannya,
            'total' => $antriannya->count()
        ], 200);
    }

    /**
     * Menampilkan data antrian berdasarkan poli.
     *
     * @param  string  $poli
     * @return \Illuminate\Http\Response
     */
    public function showAntrianByPoli($poli)
    {
        Log::info("Fetching antrian for poli: " . $poli);
        try {
            $antrian = Antrians::where('poli', $poli)->get();
            return response()->json($antrian, 200);  // 200 OK status code
        } catch (\Exception $e) {
            Log::error("Error fetching antrian for poli: " . $poli . ". Error: " . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data antrian.'], 500); // 500 Error
        }
    }

    /**
     * Mengupdate data antrian.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Menghapus data antrian.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->delete();
            return response()->json([
                'message' => 'Antrian berhasil dihapus.',
            ], 200);  // 200 OK status code
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menghapus antrian.',
            ], 500);  // 500 Internal Server Error
        }
    }

    /**
     * Menampilkan data antrian untuk edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $antrian = Antrians::find($id);

        if ($antrian) {
            return response()->json($antrian);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }

    // Metode untuk memperbarui data
    public function updateAntrian(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        // Find the antrian by ID
        $antrian = Antrians::find($id);

        // Check if antrian exists
        if (!$antrian) {
            return response()->json(['message' => 'Antrian not found'], 404);
        }

        // Update the antrian data
        $antrian->nama = $validatedData['nama'];
        $antrian->no_ktp = $validatedData['no_ktp'];
        $antrian->alamat = $validatedData['alamat'];

        // Save the updated antrian
        $antrian->save();

        return response()->json(['message' => 'Data antrian updated successfully']);
    }



    /**
     * Memanggil nomor antrian.
     *
     * @param  int  $noAntrian
     * @return \Illuminate\Http\Response
     */
    public function panggil($noAntrian)
    {
        // Logic for calling the queue number
        return response()->json(['message' => 'Memanggil nomor antrian: ' . $noAntrian], 200);  // 200 OK
    }

    /**
     * Mengunggah rekam medis ke antrian tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadRekamMedis(Request $request, $id)
    {
        try {
            $request->validate([
                'rekam_medis' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
            ]);

            $antrian = Antrians::findOrFail($id);

            if ($request->hasFile('rekam_medis')) {
                $file = $request->file('rekam_medis');

                // Delete old file if exists
                if ($antrian->rekam_medis) {
                    $oldFilePath = public_path('storage/rekam_medis/' . $antrian->rekam_medis);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Generate unique filename
                $fileName = time() . '_' . $id . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());

                // Store file directly to public/storage/rekam_medis
                $destinationPath = public_path('storage/rekam_medis');

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);

                // Save filename to database
                $antrian->rekam_medis = $fileName;
                $antrian->save();

                Log::info("Rekam medis uploaded successfully for antrian ID: {$id}, File: {$fileName}");

                // Flash message for success
                return redirect()->route('dashboardoc')->with('success', 'Rekam medis berhasil diunggah!');
            }

            return redirect()->route('dashboardoc')->with('error', 'File tidak ditemukan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('dashboardoc')->withErrors($e->errors())->with('error', 'File tidak valid. Pastikan format PDF/DOC/DOCX dan ukuran max 5MB.');
        } catch (\Exception $e) {
            Log::error('Error uploading rekam medis: ' . $e->getMessage());
            return redirect()->route('dashboardoc')->with('error', 'Terjadi kesalahan saat mengunggah rekam medis.');
        }
    }

    /**
     * View rekam medis file in dedicated preview page
     */
    public function viewRekamMedis($filename)
    {
        $filePath = public_path('storage/rekam_medis/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $fileUrl = asset('storage/rekam_medis/' . $filename);

        // Determine download route based on current middleware
        $downloadRoute = session()->has('dokter_id') ? 'rekammedis.download' : 'admin.rekammedis.download';

        return view('rekam-medis-preview', [
            'filename' => $filename,
            'fileType' => $fileExtension,
            'fileUrl' => $fileUrl,
            'downloadRoute' => $downloadRoute
        ]);
    }

    

    /**
     * Download rekam medis file
     */
    public function downloadRekamMedis($filename)
    {
        $filePath = public_path('storage/rekam_medis/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($filePath, $filename);
    }

    public function filterAntrian(Request $request)
    {
        $request->validate([
            'poli' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        $antrian = Antrians::where('poli', $request->poli)
            ->whereDate('tanggal_daftar', $request->tanggal)
            ->get();

        return response()->json($antrian);
    }
    public function daftarAntrianUser(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
                }
                return redirect()->route('login');
            }

            $antrianUser = Antrians::where('user_id', $user->id)
                ->orderBy('tanggal_daftar', 'desc')
                ->orderBy('no_antrian', 'asc')
                ->get();

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Daftar antrian ditemukan.',
                    'data' => $antrianUser
                ], 200);
            }

            return view('patient.antrianmu', compact('antrianUser'));
        } catch (JWTException $e) {
            Log::error('JWT exception in daftarAntrianUser: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Token tidak valid'], 401);
            }
            return redirect()->route('login');
        }
    }
    public function getAntrianByPoliAndDate(Request $request) //API 
    {
        // Validasi input poli dan tanggal
        $request->validate([
            'poli' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Ambil parameter poli dan tanggal dari request
        $poli = $request->input('poli');
        $tanggal = $request->input('tanggal');

        // Log untuk memeriksa nilai parameter yang diterima
        Log::info("Menerima request untuk antrian dengan poli: {$poli} dan tanggal: {$tanggal}");

        // Query data antrian berdasarkan poli dan tanggal
        $antrian = Antrians::where('poli', $poli)
            ->whereDate('tanggal_daftar', $tanggal)
            ->select('no_antrian', 'poli', 'tanggal_daftar', 'nama',)
            ->get();

        // Cek apakah data ditemukan
        if ($antrian->isEmpty()) {
            Log::warning("Tidak ada antrian ditemukan untuk poli: {$poli} dan tanggal: {$tanggal}");
            return response()->json([
                'status' => 'success',
                'message' => 'Tidak ada antrian ditemukan.',
                'data' => []
            ], 200);
        }

        // Mengembalikan response dengan data antrian
        return response()->json([
            'status' => 'success',
            'message' => 'Daftar antrian ditemukan.',
            'data' => $antrian
        ], 200);
    }



    public function daftarAntrianAPI(Request $request)
    {
        try {
            // Ambil data user berdasarkan token JWT
            $user = JWTAuth::parseToken()->authenticate();

            // Pastikan user ditemukan
            if (!$user) {
                Log::error('User not found for token: ' . $request->bearerToken());

                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found or token expired.',
                ], 401); // Status 401 Unauthorized
            }

            // Ambil data antrian yang sesuai dengan user_id
            $antrian = Antrians::where('user_id', $user->id)->get();

            // Kembalikan response dalam format JSON
            return response()->json([
                'status' => 'success',
                'message' => 'Daftar antrian berhasil diambil.',
                'data' => $antrian
            ], 200); // Status 200 OK
        } catch (JWTException $e) {
            Log::error('JWT exception: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid atau user tidak terautentikasi.',
            ], 401); // Status 401 Unauthorized
        } catch (\Exception $e) {
            Log::error('Exception while fetching antrian: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengambil data antrian.',
            ], 500); // Status 500 Internal Server Error
        }
    }

    /**
     * Get dashboard statistics for doctor dashboard.
     *
     * @param  string|null  $poliFilter
     * @return array
     */
    public function getDashboardStatistics($poliFilter = null)
    {
        try {
            // Build base query with poli filter if provided
            $baseQuery = Antrians::query();
            if ($poliFilter) {
                $baseQuery->where('poli', $poliFilter);
            }

            // Total antrian (all time)
            $totalAntrian = (clone $baseQuery)->count();

            // Antrian hari ini
            $antrianHariIni = (clone $baseQuery)->whereDate('tanggal_daftar', today())->count();

            // Breakdown per poli (all time)
            if ($poliFilter) {
                // If filtering by poli, just show that poli
                $antrianPerPoli = [$poliFilter => $totalAntrian];
            } else {
                $antrianPerPoli = Antrians::select('poli', DB::raw('count(*) as total'))
                    ->groupBy('poli')
                    ->get()
                    ->pluck('total', 'poli')
                    ->toArray();
            }

            // Breakdown per poli (hari ini)
            if ($poliFilter) {
                // If filtering by poli, just show that poli
                $antrianPerPoliHariIni = [$poliFilter => $antrianHariIni];
            } else {
                $antrianPerPoliHariIni = Antrians::select('poli', DB::raw('count(*) as total'))
                    ->whereDate('tanggal_daftar', today())
                    ->groupBy('poli')
                    ->get()
                    ->pluck('total', 'poli')
                    ->toArray();
            }

            // Antrian minggu ini
            $antrianMingguIni = (clone $baseQuery)->whereBetween('tanggal_daftar', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count();

            // Antrian bulan ini
            $antrianBulanIni = (clone $baseQuery)->whereMonth('tanggal_daftar', now()->month)
                ->whereYear('tanggal_daftar', now()->year)
                ->count();

            // Recent antrian (5 terbaru)
            $recentAntrian = (clone $baseQuery)->orderBy('created_at', 'desc')
                ->take(5)
                ->get(['id', 'no_antrian', 'nama', 'poli', 'tanggal_daftar', 'created_at']);

            return [
                'total_antrian' => $totalAntrian,
                'antrian_hari_ini' => $antrianHariIni,
                'antrian_minggu_ini' => $antrianMingguIni,
                'antrian_bulan_ini' => $antrianBulanIni,
                'antrian_per_poli' => $antrianPerPoli,
                'antrian_per_poli_hari_ini' => $antrianPerPoliHariIni,
                'recent_antrian' => $recentAntrian,
                'poli_filter' => $poliFilter, // Add filter info for view
            ];
        } catch (\Exception $e) {
            Log::error('Error fetching dashboard statistics: ' . $e->getMessage());
            return [
                'total_antrian' => 0,
                'antrian_hari_ini' => 0,
                'antrian_minggu_ini' => 0,
                'antrian_bulan_ini' => 0,
                'antrian_per_poli' => [],
                'antrian_per_poli_hari_ini' => [],
                'recent_antrian' => [],
                'poli_filter' => $poliFilter,
            ];
        }
    }

    /**
     * Show doctor dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function showDoctorDashboard(Request $request)
    {
        $user = auth()->user();

        $dokterPoli = $user->poli_spesialisasi;
        $dokterName = $user->name;

        $stats = $this->getDashboardStatistics($dokterPoli);

        $showCompleted = $request->get('show_completed', false);

        $query = Antrians::where('poli', $dokterPoli);

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

        $allAntrian = $query->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        $stats['dokter_name'] = $dokterName;
        $stats['dokter_poli'] = $dokterPoli;
        $stats['all_antrian'] = $allAntrian;
        $stats['show_completed'] = $showCompleted;

        return view('doctor.dashboard', $stats);
    }

    /**
     * Get diagnosa data for an antrian (for dokter).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDiagnosa($id)
    {
        try {
            $antrian = Antrians::findOrFail($id);

            $data = [
                // Basic info
                'id' => $antrian->id,
                'nama' => $antrian->nama,
                'no_ktp' => $antrian->no_ktp,
                'jenis_kelamin' => $antrian->jenis_kelamin,
                'tgl_lahir' => $antrian->tgl_lahir,
                'alamat' => $antrian->alamat,
                'no_hp' => $antrian->no_hp,

                // Vital Signs
                'tekanan_darah' => $antrian->tekanan_darah,
                'suhu_tubuh' => $antrian->suhu_tubuh,
                'nadi' => $antrian->nadi,
                'tinggi_badan' => $antrian->tinggi_badan,
                'berat_badan' => $antrian->berat_badan,

                // Examination
                'keluhan_utama' => $antrian->keluhan_utama,
                'riwayat_penyakit' => $antrian->riwayat_penyakit,
                'pemeriksaan_fisik' => $antrian->pemeriksaan_fisik,
                'hasil_lab' => $antrian->hasil_lab,

                // Diagnosis & Treatment
                'diagnosa' => $antrian->diagnosa,
                'tindakan_medis' => $antrian->tindakan_medis,
                'resep_obat' => $antrian->resep_obat,
                'anjuran' => $antrian->anjuran,
                'catatan_dokter' => $antrian->catatan_dokter,

                // Medical Files (decode JSON)
                'foto_pemeriksaan' => $antrian->foto_pemeriksaan ? json_decode($antrian->foto_pemeriksaan, true) : [],
                'foto_rontgen' => $antrian->foto_rontgen ? json_decode($antrian->foto_rontgen, true) : [],
                'file_pendukung' => $antrian->file_pendukung ? json_decode($antrian->file_pendukung, true) : [],

                // Doctor info
                'nama_dokter' => $antrian->nama_dokter,
                'dokter_poli' => $antrian->dokter_poli,
                'tanggal_periksa' => $antrian->tanggal_periksa ? $antrian->tanggal_periksa->format('d M Y H:i') : null,

                // Legacy field
                'rekam_medis' => $antrian->rekam_medis,
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error getting diagnosa: ' . $e->getMessage());
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }
    }

    /**
     * Save or update diagnosa for an antrian (for dokter).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveDiagnosa(Request $request, $id)
    {
        try {
            $request->validate([
                'keluhan_utama' => 'required|string',
                'diagnosa' => 'required|string',
                'resep_obat' => 'required|string',
                'tekanan_darah' => 'nullable|string',
                'suhu_tubuh' => 'nullable|string',
                'nadi' => 'nullable|string',
                'tinggi_badan' => 'nullable|numeric',
                'berat_badan' => 'nullable|numeric',
                'riwayat_penyakit' => 'nullable|string',
                'pemeriksaan_fisik' => 'nullable|string',
                'hasil_lab' => 'nullable|string',
                'tindakan_medis' => 'nullable|string',
                'anjuran' => 'nullable|string',
                'catatan_dokter' => 'nullable|string',
                'foto_pemeriksaan.*' => 'nullable|image|max:5120',
                'foto_rontgen.*' => 'nullable|image|max:5120',
                'file_pendukung.*' => 'nullable|file|max:5120',
                'rekam_medis' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            ]);

            $antrian = Antrians::findOrFail($id);
            $user = auth()->user();

            $antrian->update([
                'tekanan_darah' => $request->input('tekanan_darah'),
                'suhu_tubuh' => $request->input('suhu_tubuh'),
                'nadi' => $request->input('nadi'),
                'tinggi_badan' => $request->input('tinggi_badan'),
                'berat_badan' => $request->input('berat_badan'),
                'keluhan_utama' => $request->input('keluhan_utama'),
                'riwayat_penyakit' => $request->input('riwayat_penyakit'),
                'pemeriksaan_fisik' => $request->input('pemeriksaan_fisik'),
                'hasil_lab' => $request->input('hasil_lab'),
                'diagnosa' => $request->input('diagnosa'),
                'tindakan_medis' => $request->input('tindakan_medis'),
                'resep_obat' => $request->input('resep_obat'),
                'anjuran' => $request->input('anjuran'),
                'catatan_dokter' => $request->input('catatan_dokter'),
                'dokter_id' => $user->id,
                'nama_dokter' => $user->name,
                'dokter_poli' => $user->poli_spesialisasi,
                'tanggal_periksa' => now(),
            ]);

            // Handle Multiple File Uploads - Foto Pemeriksaan
            if ($request->hasFile('foto_pemeriksaan')) {
                $fotoPemeriksaan = [];
                $destinationPath = public_path('storage/foto_pemeriksaan');

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($request->file('foto_pemeriksaan') as $file) {
                    $filename = time() . '_pemeriksaan_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $fotoPemeriksaan[] = $filename;
                }

                $antrian->foto_pemeriksaan = json_encode($fotoPemeriksaan);
                Log::info("Uploaded " . count($fotoPemeriksaan) . " foto pemeriksaan for antrian ID: {$id}");
            }

            // Handle Multiple File Uploads - Foto Rontgen
            if ($request->hasFile('foto_rontgen')) {
                $fotoRontgen = [];
                $destinationPath = public_path('storage/foto_rontgen');

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($request->file('foto_rontgen') as $file) {
                    $filename = time() . '_rontgen_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $fotoRontgen[] = $filename;
                }

                $antrian->foto_rontgen = json_encode($fotoRontgen);
                Log::info("Uploaded " . count($fotoRontgen) . " foto rontgen for antrian ID: {$id}");
            }

            // Handle Multiple File Uploads - File Pendukung
            if ($request->hasFile('file_pendukung')) {
                $filePendukung = [];
                $destinationPath = public_path('storage/file_pendukung');

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($request->file('file_pendukung') as $file) {
                    $filename = time() . '_pendukung_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($destinationPath, $filename);
                    $filePendukung[] = $filename;
                }

                $antrian->file_pendukung = json_encode($filePendukung);
                Log::info("Uploaded " . count($filePendukung) . " file pendukung for antrian ID: {$id}");
            }

            // Handle legacy rekam_medis file upload (keep for backward compatibility)
            if ($request->hasFile('rekam_medis')) {
                $file = $request->file('rekam_medis');

                // Delete old file if exists
                if ($antrian->rekam_medis) {
                    $oldFilePath = public_path('storage/rekam_medis/' . $antrian->rekam_medis);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                        Log::info("Deleted old rekam medis file: {$antrian->rekam_medis}");
                    }
                }

                // Generate unique filename
                $fileName = time() . '_' . $id . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());

                // Store file directly to public/storage/rekam_medis
                $destinationPath = public_path('storage/rekam_medis');

                // Ensure directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);

                // Save filename to database
                $antrian->rekam_medis = $fileName;

                Log::info("Rekam medis uploaded for antrian ID: {$id}, File: {$fileName}");
            }

            // Save all changes
            $antrian->save();

            Log::info("Rekam medis lengkap berhasil disimpan untuk antrian ID: {$id}", [
                'diagnosa' => $antrian->diagnosa,
                'keluhan_utama' => $antrian->keluhan_utama,
                'nama_dokter' => $antrian->nama_dokter,
            ]);

            return response()->json([
                'message' => 'Rekam medis berhasil disimpan!',
                'data' => $antrian
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error saving rekam medis: ' . json_encode($e->errors()));
            return response()->json([
                'error' => 'Data tidak valid.',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saving rekam medis: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show archived antrian for doctor (completed > 1 day ago).
     *
     * @return \Illuminate\View\View
     */
public function showDoctorArchive(Request $request)
    {
        $user = auth()->user();
        $dokterPoli = $user->poli_spesialisasi;
        $dokterName = $user->name;

        $archivedAntrian = Antrians::where('poli', $dokterPoli)
            ->whereIn('status', ['selesai', 'skip'])
            ->where('updated_at', '<', now()->subDays(1))
            ->orderBy('updated_at', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return view('doctor.archive', [
            'dokter_name' => $dokterName,
            'dokter_poli' => $dokterPoli,
            'archived_antrian' => $archivedAntrian,
        ]);
    }

    public function getAntrianDataAjax(Request $request)
    {
        $user = auth()->user();

        if (!$user || !$user->poli_spesialisasi) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $dokterPoli = $user->poli_spesialisasi;
        $showCompleted = $request->get('show_completed', false);

        $query = Antrians::where('poli', $dokterPoli);

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

        $antrian = $query->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return response()->json($antrian);
    }

    public function getAllAntrian(): \Illuminate\Http\JsonResponse
    {
        $antrian = Antrians::with('user')
            ->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar antrian ditemukan.',
            'data' => $antrian
        ]);
    }

    public function getDoctorAntrian(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $dokterPoli = $user->poli_spesialisasi;
        $showCompleted = $request->get('show_completed', false);

        $query = Antrians::where('poli', $dokterPoli);

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

        $antrian = $query->orderBy('tanggal_daftar', 'desc')
            ->orderBy('no_antrian', 'asc')
            ->get();

        return response()->json($antrian);
    }

    public function panggilAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->update([
                'status' => 'dipanggil',
                'dipanggil_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dipanggil!',
                'data' => $antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan.'
            ], 400);
        }
    }

    public function skipAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->update([
                'status' => 'skip',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil di-skip!',
                'data' => $antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan.'
            ], 400);
        }
    }

    public function selesaiAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->update([
                'status' => 'selesai',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil diselesaikan!',
                'data' => $antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyelesaikan antrian.'
            ], 500);
        }
    }

    public function resetAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->update([
                'status' => 'menunggu',
                'dipanggil_at' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status antrian berhasil direset!',
                'data' => $antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mereset antrian.'
            ], 500);
        }
    }

    public function deleteAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::findOrFail($id);
            $antrian->delete();

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus antrian.'
            ], 500);
        }
    }

    public function getAntrian(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $antrian = Antrians::with('user')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data antrian ditemukan.',
                'data' => $antrian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan.'
            ], 404);
        }
    }

    public function getAntrianDetail(int $id): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        $antrian = Antrians::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$antrian) {
            return response()->json([
                'success' => false,
                'message' => 'Antrian tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $antrian
        ]);
    }

    public function getAllPasien(): \Illuminate\Http\JsonResponse
    {
        $pasien = Antrians::with('user')
            ->whereNotNull('diagnosa')
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pasien
        ]);
    }

    public function getPasienDetail(int $id): \Illuminate\Http\JsonResponse
    {
        $pasien = Antrians::with('user')->find($id);

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Pasien tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pasien
        ]);
    }
}
