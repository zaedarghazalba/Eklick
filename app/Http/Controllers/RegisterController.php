<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     * 
     * For Web: Show registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');  // Untuk Web: Menampilkan form registrasi
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',  // Memastikan bahwa password_confirmation sesuai
                Password::min(8),  // Minimal panjang password 8 karakter
            ],
            'password_confirmation' => 'required|same:password', // Validasi konfirmasi password
            'terms' => 'required|accepted', // Validasi terms harus di-accept
        ], [
            'terms.required' => 'You must accept the terms and conditions.',
            'terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        try {
            // Membuat pengguna baru dengan role default 'user'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Meng-hash password sebelum disimpan
                'role' => 'user', // Default role untuk pasien
            ]);

            // Jika menggunakan API, kita akan login menggunakan guard api
            if ($request->expectsJson()) {
                // Mengirimkan respons JSON untuk API
                return response()->json([
                    'status' => 'success',
                    'message' => 'Your account has been created and you are now logged in.',
                    'user' => $user,
                ], 201); // Status 201 untuk "created"
            }

            // Login pengguna otomatis setelah registrasi (untuk Web)
            Auth::login($user);

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Simpan user_id di session
            session(['user_id' => $user->id]);

            // Web: Redirect ke halaman utama setelah registrasi sukses
            return redirect()->route('home')->with('success', 'Registration successful! Welcome to our clinic.'); // Mengarahkan ke halaman utama setelah registrasi
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Registration failed: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
