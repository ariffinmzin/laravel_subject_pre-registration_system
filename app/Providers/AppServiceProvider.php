<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    public function boot(): void
    {
        //
        // 3
        Gate::define('is-admin', function($user){
            return $user->role === 'administrator';
        });

        Gate::define('is-lecturer', function($user){
            return $user->role === 'lecturer';
        });

        Gate::define('is-student', function ($user) {
            return $user->role === 'student';
        });

        Paginator::useBootstrap();

        // Paginator::defaultView('vendor.pagination.bootstrap-5');
        
    }
}
