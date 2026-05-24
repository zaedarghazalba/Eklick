<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAntrianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poli' => ['sometimes', 'string', 'max:100'],
            'tanggal_daftar' => ['sometimes', 'date'],
            'nama' => ['sometimes', 'string', 'max:255'],
            'no_ktp' => ['sometimes', 'digits:16'],
            'alamat' => ['sometimes', 'string', 'max:500'],
            'jenis_kelamin' => ['sometimes', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['sometimes', 'regex:/^(\+62|0)[0-9]{9,12}$/'],
            'tgl_lahir' => ['sometimes', 'date', 'before:today'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'rekam_medis' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'status' => ['nullable', 'string', 'in:menunggu,dipanggil,selesai'],
        ];
    }

    public function messages(): array
    {
        return [
            'poli.max' => 'Nama poli maksimal 100 karakter.',
            'tanggal_daftar.date' => 'Format tanggal tidak valid.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'no_ktp.digits' => 'No. KTP harus 16 digit.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'no_hp.regex' => 'Format No. HP tidak valid.',
            'tgl_lahir.before' => 'Tanggal lahir tidak valid.',
            'status.in' => 'Status tidak valid.',
            'rekam_medis.mimes' => 'File rekam medis harus PDF, JPG, JPEG, atau PNG.',
            'rekam_medis.max' => 'Ukuran file maksimal 5MB.',
        ];
    }
}