<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if (!$user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak aktif.']);
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // User is authenticated but doesn't have required role
        // Logout and redirect to login with message
        $requiredRole = $roles[0] ?? 'required';
        $message = '';
        
        if ($requiredRole === 'admin' && $user->isKetuaRT()) {
            $message = 'Anda login sebagai Ketua RT. Untuk mengakses dashboard Admin, silakan login sebagai Admin.';
        } elseif ($requiredRole === 'ketua_rt' && $user->isAdmin()) {
            $message = 'Anda login sebagai Admin. Untuk mengakses dashboard Ketua RT, silakan login sebagai Ketua RT.';
        } else {
            $message = 'Anda tidak memiliki akses ke halaman ini.';
        }
        
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->withErrors(['email' => $message]);
    }
}
