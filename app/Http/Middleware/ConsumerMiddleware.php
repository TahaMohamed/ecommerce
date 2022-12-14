<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConsumerMiddleware
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
        if (auth()->check() && auth()->user()->user_type == 'consumer' && auth()->user()->has_rights_to_access) {
            return $next($request);
        }else{
            return response()->json([
                'status' => false ,
                'message' => __('auth.failed'),
                'data' => null
                ] ,401);
        }
    }
}
