<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
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
        Log::info('Request data: ', $request->all());

        // Validate request data
        $validatedData = $this->validateRequest($request);

        // Handle file upload
        $validatedData['rekam_medis'] = $this->handleFileUpload($request);

        // Get user_id and set next queue number
        $validatedData['user_id'] = $request->session()->get('user_id');
        $validatedData['no_antrian'] = $this->getNextQueueNumber();

        try {
            // Save the antrian data into the database
            Antrian::create($validatedData);
            return response()->json([
                'message' => 'Antrian berhasil disimpan.',
                'data' => $validatedData,
            ], 201);  // 201 Created status code
        } catch (\Exception $e) {
            Log::error("Error saving antrian: " . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan antrian.',
            ], 500);  // 500 Internal Server Error
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
     * Mendapatkan nomor antrian berikutnya.
     *
     * @return int
     */
    private function getNextQueueNumber()
    {
        $latestAntrian = Antrian::orderBy('created_at', 'asc')->first();
        return $latestAntrian ? $latestAntrian->no_antrian + 1 : 1;
    }

    /**
     * Menampilkan semua data antrian.
     *
     * @return \Illuminate\Http\Response
     */
    public function daftar()
    {
        $antriannya = Antrian::all();
        return response()->json($antriannya, 200); // 200 OK status code
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
            $antrian = Antrian::where('poli', $poli)->get();
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
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'poli' => 'required',
            'tanggal_daftar' => 'required',
            'nama' => 'required',
            'no_ktp' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required',
            'tgl_lahir' => 'required|date',
            'pekerjaan' => 'required',
        ]);

        try {
            $antrian = Antrian::findOrFail($id);
            $antrian->update($validatedData);
            return response()->json([
                'message' => 'Antrian berhasil diupdate.',
                'data' => $validatedData,
            ], 200);  // 200 OK status code
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengupdate antrian.',
            ], 500);  // 500 Internal Server Error
        }
    }

    /**
     * Menghapus data antrian.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $antrian = Antrian::findOrFail($id);
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
        try {
            $antrian = Antrian::findOrFail($id);
            return response()->json($antrian, 200);  // 200 OK status code
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data antrian.'], 500); // 500 Error
        }
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
    $request->validate([
        'rekam_medis' => 'required|mimes:pdf,doc,docx|max:2048',
    ]);

    $antrian = Antrian::find($id);

    if ($request->hasFile('rekam_medis')) {
        $file = $request->file('rekam_medis');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('rekam_medis', $fileName, 'public');

        // Save the path to the database
        $antrian->rekam_medis = $fileName;
        $antrian->save();

        // Flash message for success
        return redirect()->route('dashboardoc')->with('success', 'Rekam medis berhasil diunggah.');
    }

    return redirect()->route('dashboardoc')->with('error', 'Terjadi kesalahan saat mengunggah rekam medis.');
}

}
