<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDiagnosaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'diagnosa' => ['required', 'string', 'max:1000'],
            'catatan_dokter' => ['nullable', 'string', 'max:2000'],
            'resep_obat' => ['nullable', 'string', 'max:2000'],
            'tekanan_darah' => ['nullable', 'string', 'max:20'],
            'suhu_tubuh' => ['nullable', 'numeric', 'min:30', 'max:45'],
            'nadi' => ['nullable', 'integer', 'min:30', 'max:200'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'berat_badan' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'keluhan_utama' => ['nullable', 'string', 'max:1000'],
            'riwayat_penyakit' => ['nullable', 'string', 'max:1000'],
            'pemeriksaan_fisik' => ['nullable', 'string', 'max:2000'],
            'hasil_lab' => ['nullable', 'string', 'max:1000'],
            'tindakan_medis' => ['nullable', 'string', 'max:1000'],
            'anjuran' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'diagnosa.required' => 'Diagnosa wajib diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 1000 karakter.',
            'catatan_dokter.max' => 'Catatan dokter maksimal 2000 karakter.',
            'resep_obat.max' => 'Resep obat maksimal 2000 karakter.',
            'suhu_tubuh.numeric' => 'Suhu tubuh harus angka.',
            'suhu_tubuh.min' => 'Suhu tubuh tidak valid.',
            'suhu_tubuh.max' => 'Suhu tubuh tidak valid.',
            'nadi.integer' => 'Nadi harus angka.',
            'nadi.min' => 'Nilai nadi tidak valid.',
            'nadi.max' => 'Nilai nadi tidak valid.',
            'tinggi_badan.numeric' => 'Tinggi badan harus angka.',
            'berat_badan.numeric' => 'Berat badan harus angka.',
        ];
    }
}