<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        if ($response->isServerError()) {
            // Convertir les erreurs en JSON
            $response = response()->json(['message' => 'Internal Server Error, Please contact Administrator.', 'data' => ['Internal Server Error']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}