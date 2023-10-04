<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ( ! User::isAdmin($request->user('sanctum'))) {

            return Response()->json(
                [
                    'message' => 'Forbidden',
                    'errors' => [
                        'access' => "Forbidden. You must be administrator."
                    ]
                ], 403);

        }
        return $next($request);
    }
}
