<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
   
   if (Auth::check()) {
    
    if (Auth::user()->role === 'admin') {
        
        return redirect()->route('admin.product.index');
    }
}

// Allow the request to proceed if not authenticated or not an admin
return $next($request);
}
}
