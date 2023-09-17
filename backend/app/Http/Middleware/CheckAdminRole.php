<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and has the "admin" role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // If the user is not authenticated or doesn't have the "admin" role, return an unauthorized response
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
