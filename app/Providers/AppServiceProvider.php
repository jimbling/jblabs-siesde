<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $role = null;

            if ($user) {
                $role = $user->roles->first()->name ?? null;
            }

            $view->with([
                'user' => $user,
                'userRole' => $role,
            ]);
        });

        // Atur lokal Carbon dan PHP
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.UTF-8', 'id_ID', 'Indonesian_indonesia', 'Indonesian');
    }
}
