<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

final class UnifiedAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'sometimes|string|in:admin,dokter,user',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membuat token'
            ], 500);
        }

        $user = auth()->user();

        if ($request->has('role') && $user->role->value !== $request->role) {
            try {
                JWTAuth::invalidate(JWTAuth::getToken());
            } catch (\Exception $e) {
                // Token may already be invalid, continue
            }
            return response()->json([
                'success' => false,
                'message' => 'Role tidak sesuai'
            ], 403);
        }

        $additionalClaims = [
            'role' => $user->role->value,
            'name' => $user->name,
            'poli' => $user->poli_spesialisasi,
        ];

        $token = JWTAuth::customClaims($additionalClaims)->fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->value,
                    'poli' => $user->poli_spesialisasi,
                ],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => (int) config('jwt.ttl') * 60
            ]
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::USER,
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role->value,
                ],
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => (int) config('jwt.ttl') * 60
            ]
        ], 201);
    }

    public function profile(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'poli' => $user->poli_spesialisasi,
                'created_at' => $user->created_at?->toIso8601String(),
            ]
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
        ]);

        $user->update($request->only(['name', 'phone', 'address']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
            ]
        ]);
    }

    public function logout(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        try {
            // Invalidate JWT token
            JWTAuth::invalidate(JWTAuth::getToken());

            // Clear session for web logout
            if (!$this->isApiRequest($request)) {
                $request->session()->forget(['jwt_token', 'user_id', 'user_role', 'user_name']);
                return redirect()->route('login')->with('success', 'Logout berhasil!');
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ]);
        } catch (JWTException $e) {
            // Even if token invalidation fails, clear session
            if (!$this->isApiRequest($request)) {
                $request->session()->forget(['jwt_token', 'user_id', 'user_role', 'user_name']);
                return redirect()->route('login');
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat logout'
            ], 500);
        }
    }

    private function isApiRequest(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }

    public function refreshToken(): JsonResponse
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Token refreshed',
                'data' => [
                    'token' => $newToken,
                    'token_type' => 'bearer',
                    'expires_in' => (int) config('jwt.ttl') * 60
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token refresh failed'
            ], 401);
        }
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->value,
                'poli' => $user->poli_spesialisasi,
            ]
        ]);
    }

    // Web Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    

    // Handle Web Login (Form submission - redirects based on role)
    public function webLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
            }
        } catch (JWTException $e) {
            return back()->withErrors(['email' => 'Tidak dapat membuat token'])->withInput();
        }

        $user = auth()->user();

        // Store token in session for web access
        $request->session()->put('jwt_token', $token);
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_role', $user->role->value);
        $request->session()->put('user_name', $user->name);

        // Redirect based on role
        return match ($user->role->value) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dashboardoc'),
            default => redirect()->route('home'),
        };
    }
}