<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
              // Cek jika user sudah login DAN role-nya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tendang ke halaman dashboard user
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin!');
    }
    
}
