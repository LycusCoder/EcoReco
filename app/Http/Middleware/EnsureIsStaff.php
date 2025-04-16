<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsStaff
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Pastikan user memiliki ID antara 1-5
        $allowedIds = [1, 2, 3, 4, 5];
        if (!in_array(auth()->id(), $allowedIds)) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
