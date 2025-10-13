<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Pastikan role ada sebelum dicek
        if (!$user->role || !in_array($user->role, $roles)) {
            abort(403, 'Anda tidak punya akses ke halaman ini');
        }

        return $next($request);
    }
}