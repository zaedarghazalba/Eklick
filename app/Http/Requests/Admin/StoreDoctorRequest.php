<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === UserRole::ADMIN;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'poli_spesialisasi' => ['required', 'string', 'max:100', Rule::in([
                'Umum', 'Mata', 'THT', 'Ibu Dan Anak', 'Syaraf', 'Kulit Dan Kelamin'
            ])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama dokter wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'poli_spesialisasi.required' => 'Poli spesialisasi wajib dipilih.',
            'poli_spesialisasi.in' => 'Poli spesialisasi tidak valid.',
        ];
    }
}