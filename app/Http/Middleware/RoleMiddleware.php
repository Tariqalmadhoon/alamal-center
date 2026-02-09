<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // إذا كان المستخدم admin يستطيع الوصول لكل شيء
        if ($request->user()->role === 'admin') {
            return $next($request);
        }

        // إذا كان الـ role المطلوب هو admin والمستخدم ليس admin
        if ($role === 'admin' && $request->user()->role !== 'admin') {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة');
        }

        return $next($request);
    }
}
