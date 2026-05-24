<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;


class AuthControll extends Controller
{
    public function show(Request $request)
    {
        request()->session()->put('urlback', request()->session()->previousUrl());
        return view('auth.login');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    //sso
    // Fungsi untuk mengambil informasi pengguna dari Google dan menyimpannya ke dalam sesi
    private function getUserFromGoogleAndStoreInSession()
    {
        // Google user object dari google
        $userFromGoogle = Socialite::driver('google')->user();

        // Cek apakah user dengan google_id ini sudah ada
        $userFromDatabase = User::where('google_id', $userFromGoogle->getId())->first();

        // Jika tidak ada, cek berdasarkan email (untuk merge account manual dengan OAuth)
        if (!$userFromDatabase) {
            $userFromDatabase = User::where('email', $userFromGoogle->getEmail())->first();

            if ($userFromDatabase) {
                // User sudah ada dari registrasi manual, update google_id untuk merge account
                $userFromDatabase->google_id = $userFromGoogle->getId();
                $userFromDatabase->save();

                Log::info('Merged manual account with Google OAuth for email: ' . $userFromGoogle->getEmail());
            } else {
                // User benar-benar baru, buat account baru dengan role default 'user'
                $userFromDatabase = User::create([
                    'google_id' => $userFromGoogle->getId(),
                    'name' => $userFromGoogle->getName(),
                    'email' => $userFromGoogle->getEmail(),
                    'password' => null, // OAuth users tidak perlu password
                    'role' => 'user', // Default role untuk pasien
                ]);

                Log::info('Created new OAuth user: ' . $userFromGoogle->getEmail());
            }
        }

        // Login user menggunakan Auth facade
        Auth::login($userFromDatabase);

        // Regenerate session untuk keamanan
        request()->session()->regenerate();

        // Simpan informasi pengguna ke dalam sesi
        request()->session()->put('sso', $userFromDatabase);

        // Simpan user_id di session
        request()->session()->put('user_id', $userFromDatabase->id);
    }

    public function handleProviderCallback()
    {
        // dd(1);
        try {
            // Mengambil informasi pengguna dari Google dan menyimpannya ke dalam sesi
            $this->getUserFromGoogleAndStoreInSession();

            // Membersihkan session 'urlback' jika ada
            request()->session()->forget('urlback');

            // Mengarahkan pengguna ke halaman home jika ada session 'urlback', jika tidak kembali ke halaman home secara default
            if (request()->session()->has('urlback')) {
                return redirect(request()->session()->get('urlback'));
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            // Menangani kesalahan dengan menampilkan pesan kesalahan atau mengarahkan pengguna kembali ke halaman login
            return redirect()->route('googlesso')->with('error', 'Terjadi kesalahan saat melakukan autentikasi. Silakan coba lagi.');
        }
    }

    public function sso_auto()
    {
        try {
            // Mengambil informasi pengguna dari Google dan menyimpannya ke dalam sesi
            $this->getUserFromGoogleAndStoreInSession();

            // Membersihkan session 'urlback' jika ada
            request()->session()->forget('urlback');

            // Mengarahkan pengguna ke halaman home jika ada session 'urlback', jika tidak kembali ke halaman home secara default
            if (request()->session()->has('urlback')) {
                return redirect(request()->session()->get('urlback'));
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('SSO auto login failed: ' . $e->getMessage());
            // Menangani kesalahan dengan menampilkan pesan kesalahan atau mengarahkan pengguna kembali ke halaman login
            return redirect()->route('googlesso')->with('error', 'Terjadi kesalahan saat melakukan autentikasi. Silakan coba lagi.');
        }
    }


    

    // Logout pengguna (untuk API atau Web)
    public function logout()
    {
        if (Auth::guard('api')->check()) {
            // Untuk API, logout dengan token
            Auth::guard('api')->logout();
        } else {
            // Untuk Web, logout dengan session
            session()->flush();  // Menghapus semua session yang ada
            Auth::logout();      // Logout pengguna

            return redirect()->route('index');
        }

        return response()->json([
            'status' => true,
            'message' => 'Logout successful'
        ], 200);
    }
}
