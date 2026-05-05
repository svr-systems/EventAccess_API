<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAttendee {
  public function handle(Request $request, Closure $next): Response {
    if (!auth()->check() || auth()->user()->role_id !== 5) {
      return response()->json([
        'msg' => 'Acceso restringido solo para visitantes.'
      ], 403);
    }

    return $next($request);
  }
}
