<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class LoadNotifications
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())->get();
            view()->share('notifications', $notifications);
        }
        return $next($request);
    }
}
