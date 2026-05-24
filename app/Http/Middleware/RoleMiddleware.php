<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Get user role from JWT or session
        $userRole = $this->getUserRole($request);

        if (!$userRole) {
            return $this->unauthorizedResponse($request, 'Unauthorized. Please login.');
        }

        if (!in_array($userRole, $roles)) {
            return $this->forbiddenResponse($request, $userRole);
        }

        return $next($request);
    }

    private function getUserRole(Request $request): ?string
    {
        // Try JWT first (API)
        if (auth()->check()) {
            return auth()->user()->role->value ?? auth()->user()->role;
        }

        // Try session (Web)
        if ($request->session()->has('user_role')) {
            return $request->session()->get('user_role');
        }

        // Try JWT from request
        try {
            $user = auth('api')->user();
            if ($user) {
                return $user->role->value ?? $user->role;
            }
        } catch (\Exception $e) {
            // Ignore
        }

        return null;
    }

    private function unauthorizedResponse(Request $request, string $message): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 401);
        }
        return redirect()->route('login');
    }

    private function forbiddenResponse(Request $request, string $userRole): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Anda tidak memiliki akses ke resource ini.'
            ], 403);
        }

        // Redirect based on user's actual role
        return match ($userRole) {
            'admin' => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dashboardoc'),
            default => redirect()->route('home'),
        };
    }
}