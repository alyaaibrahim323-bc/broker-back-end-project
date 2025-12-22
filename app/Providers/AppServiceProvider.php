<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use App\Models\Booking;
use App\Observers\BookingObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Other registrations...
        $this->app->register(BladeIconsServiceProvider::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void

    {
        Booking::observe(BookingObserver::class);


         Paginator::useBootstrap();

        // View::composer('*', function ($view) {
        //     if (Auth::check()) { // فقط عند تسجيل الدخول
        //         $notifications = Notification::where('user_id', Auth::id())
        //         ->orWhereNull('user_id') // الإشعارات العامة
        //         ->orderBy('created_at', 'desc')
        //         ->get();

        //         $view->with('notifications', $notifications);
        //     }
        // });
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $allNotifications = Notification::where('user_id', Auth::id())
                    ->orWhereNull('user_id')
                    ->orderBy('created_at', 'desc')
                    ->get();

                $unreadNotifications = $allNotifications->where('is_read', false);

                $view->with([
                    'allNotifications' => $allNotifications,
                    'unreadCount' => $unreadNotifications->count(),
                ]);
            }
        });
    }


}
