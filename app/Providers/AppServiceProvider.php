<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;



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

        Gate::define('Administrador', function (User $user) {
            return $user->hasRole('Administrador');
        });

        Gate::define('Editor', function (User $user) {
            return $user->hasRole('Editor');
        });

        Gate::define('Consultor', function (User $user) {
            return $user->hasRole('Consultor');
        });


        
    }
}
