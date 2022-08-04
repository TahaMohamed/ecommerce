<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MerchantMiddleware
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
        if (auth()->check() && auth()->user()->user_type == 'merchant' && auth()->user()->has_rights_to_access) {
            return $next($request);
        }else{
            return response()->json([
                'status' => false ,
                'message' => __('auth.login_data_not_true'),
                'data' => null
                ] ,401);
        }
    }
}
