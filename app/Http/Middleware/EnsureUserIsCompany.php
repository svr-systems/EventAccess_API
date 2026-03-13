<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsCompany {
  public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || (auth()->user()->role_id !== 3 && auth()->user()->role_id !== 4)) {
      return response()->json([
        'msg' => 'Acceso restringido solo para empresa.'
      ], 403);
    }

    return $next($request);
  }
}
