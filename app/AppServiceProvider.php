<?php

namespace App\Providers;

use App\Models\Complaint;
use App\Models\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('shared.pagination');

        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $unreadCount = Notification::where('user_id', Auth::id())
                    ->where('status', 'Unread')
                    ->count();

                $recentNotifications = Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();

                 $pendingComplaintsCount = Complaint::where('status', 'Pending')->count();

                $view->with([
                    'unreadCount' => $unreadCount,
                    'recentNotifications' => $recentNotifications,
                    'pendingComplaintsCount' => $pendingComplaintsCount

                ]);
            }
        });
    }
}
