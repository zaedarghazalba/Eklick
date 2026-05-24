<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

final class JwtAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token && $request->hasSession()) {
            $token = $request->session()->get('jwt_token');
        }

        if (!$token) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token tidak ditemukan. Silakan login.'
                ], 401);
            }
            return redirect()->route('login');
        }

        try {
            JWTAuth::setToken($token);
            $user = JWTAuth::authenticate();

            if (!$user) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User tidak ditemukan'
                    ], 401);
                }
                return redirect()->route('login');
            }
        } catch (TokenExpiredException $e) {
            if ($request->hasSession() && $request->session()->has('jwt_token')) {
                try {
                    $newToken = JWTAuth::refresh($request->session()->get('jwt_token'));
                    $request->session()->put('jwt_token', $newToken);
                    $user = JWTAuth::setToken($newToken)->authenticate();

                    if ($user) {
                        $request->session()->put('user_id', $user->id);
                        $request->session()->put('user_role', $user->role->value ?? $user->role);
                        $request->session()->put('user_name', $user->name);
                        return $next($request);
                    }
                } catch (\Exception $e) {
                    $this->clearSession($request);
                    return redirect()->route('login');
                }
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token telah expired. Silakan login kembali.'
                ], 401);
            }
            $this->clearSession($request);
            return redirect()->route('login');
        } catch (TokenInvalidException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token tidak valid.'
                ], 401);
            }
            $this->clearSession($request);
            return redirect()->route('login');
        } catch (JWTException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token tidak ditemukan. Silakan login.'
                ], 401);
            }
            $this->clearSession($request);
            return redirect()->route('login');
        }

        if ($request->hasSession()) {
            $request->session()->put('user_id', $user->id);
            $request->session()->put('user_role', $user->role->value ?? $user->role);
            $request->session()->put('user_name', $user->name);
        }

        return $next($request);
    }

    private function clearSession(Request $request): void
    {
        if ($request->hasSession()) {
            $request->session()->forget(['jwt_token', 'user_id', 'user_role', 'user_name']);
        }
    }
}