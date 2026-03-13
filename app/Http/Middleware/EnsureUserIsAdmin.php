<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin {
  public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || (auth()->user()->role_id !== 1 && auth()->user()->role_id !== 2)) {
      return response()->json([
        'msg' => 'Acceso restringido solo para administradores.'
      ], 403);
    }

    return $next($request);
  }
}
