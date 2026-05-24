<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAntrianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poli' => ['required', 'string', 'max:100'],
            'tanggal_daftar' => ['required', 'date', 'after_or_equal:today'],
            'nama' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'digits:16'],
            'alamat' => ['required', 'string', 'max:500'],
            'jenis_kelamin' => ['required', 'in:Laki-laki,Perempuan'],
            'no_hp' => ['required', 'regex:/^(\+62|0)[0-9]{9,12}$/'],
            'tgl_lahir' => ['required', 'date', 'before:today'],
            'pekerjaan' => ['nullable', 'string', 'max:100'],
            'rekam_medis' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'poli.required' => 'Poli wajib dipilih.',
            'poli.max' => 'Nama poli maksimal 100 karakter.',
            'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
            'tanggal_daftar.after_or_equal' => 'Tanggal daftar tidak boleh di masa lalu.',
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'no_ktp.required' => 'No. KTP wajib diisi.',
            'no_ktp.digits' => 'No. KTP harus 16 digit.',
            'alamat.required' => 'Alamat wajib diisi.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'no_hp.required' => 'No. HP wajib diisi.',
            'no_hp.regex' => 'Format No. HP tidak valid (contoh: 081234567890).',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.before' => 'Tanggal lahir tidak valid.',
            'rekam_medis.mimes' => 'File rekam medis harus PDF, JPG, JPEG, atau PNG.',
            'rekam_medis.max' => 'Ukuran file maksimal 5MB.',
        ];
    }
}