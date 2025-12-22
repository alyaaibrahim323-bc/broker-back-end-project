<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // التحقق إذا كان المستخدم مسجل دخول
        if (auth()->check()) {
            // تحديث وقت آخر نشاط في الجلسة
            Session::put('last_activity', now());
        }

        // متابعة تنفيذ الطلب
        return $next($request);
    }
}

