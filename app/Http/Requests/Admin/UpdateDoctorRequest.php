<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === UserRole::ADMIN;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', 'unique:users,email,' . $this->route('id')],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'poli_spesialisasi' => ['sometimes', 'string', 'max:100', Rule::in([
                'Umum', 'Mata', 'THT', 'Ibu Dan Anak', 'Syaraf', 'Kulit Dan Kelamin'
            ])],
        ];
    }

    public function messages(): array
    {
        return [
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'poli_spesialisasi.in' => 'Poli spesialisasi tidak valid.',
        ];
    }
}