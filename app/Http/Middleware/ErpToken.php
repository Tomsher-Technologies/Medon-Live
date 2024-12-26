<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ErpToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Authorization') != env('ERP_API_KEY')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ]);
        } 

        return $next($request);
    }
}
