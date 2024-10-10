<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthControll extends Controller
{
    public function show(Request $request)
    {
        request()->session()->put('urlback', request()->session()->previousUrl());
        return view('login');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    //sso
    // Fungsi untuk mengambil informasi pengguna dari Google dan menyimpannya ke dalam sesi
    private function getUserFromGoogleAndStoreInSession()
    {
        // dd(Socialite::driver('google')->user());
        // Google user object dari google
        $userFromGoogle = Socialite::driver('google')->user();

        // Ambil user dari database berdasarkan google user id
        $userFromDatabase = User::where('google_id', $userFromGoogle->getId())->first();

        // Jika tidak ada user, maka buat user baru
        if (!$userFromDatabase) {
            $newUser = new User([
                'google_id' => $userFromGoogle->getId(),
                'name' => $userFromGoogle->getName(),
                'email' => $userFromGoogle->getEmail(),
            ]);
            $newUser->save();
            $userFromDatabase = $newUser;
        }

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

            // return redirect()->route('home');
        } catch (\Exception $e) {
            dd(2);
            // Menangani kesalahan dengan menampilkan pesan kesalahan atau mengarahkan pengguna kembali ke halaman login
            return redirect()->route('googlesso')->with('error', 'Terjadi kesalahan saat melakukan autentikasi. Silakan coba lagi.');
        }
    }
    public function logout()
    {

        Auth::logout();
        request()->session()->flush();
        return redirect()->route('index');
    }
    public function simpanLogin()
    {
        // Mengambil pengguna yang sedang login
        $user = Auth::user();

        // Jika ada pengguna yang login, Anda dapat mengakses ID-nya
        if ($user) {
            $userId = $user->id;
            // Lakukan sesuatu dengan ID pengguna yang login
            dd($userId);
        } else {
            // Jika tidak ada pengguna yang login, lakukan sesuatu sesuai kebutuhan aplikasi Anda
            dd("Tidak ada pengguna yang login");
        }
    }

    public function loginmanual(Request $request)
{
    $credentials = $request->only('name', 'password');

    if (Auth::attempt($credentials)) {
        // Jika otentikasi berhasil
        $user = Auth::user();
        $userId = $user->id;

        // Simpan user_id di session
        request()->session()->put('user_id', $userId);

        // Response JSON sukses
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'user_id' => $userId
        ], 200); // Status code 200 untuk sukses
    }

    // Jika otentikasi gagal
    return response()->json([
        'status' => 'error',
        'message' => 'Login gagal, kredensial tidak sesuai'
    ], 401); // Status code 401 untuk unauthorized
}

}
