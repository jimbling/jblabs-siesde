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

        Carbon::setLocale('id');
    }
}
