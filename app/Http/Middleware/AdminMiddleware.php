<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::check()) {
        //     if (Auth::user()->role == 'admin') {
        //         return $next($request);
        //     } else {
        //         return response()->json([
        //             'message' => 'Access Denied! You are not an Admin.',
        //         ], 403);
        //     }
        // } else {
        //     return response()->json([
        //         'status' => 401,
        //         'message' => 'Please Login First.',
        //     ]);
        // }
        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {
                return $next($request);
            } else {
                return response()->json([
                    'message' => 'Access Denied.! As you are not an Admin.',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Please Login First.',
            ]);
        }
    }
}
