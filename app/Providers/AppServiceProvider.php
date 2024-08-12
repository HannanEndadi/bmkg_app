<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate as FacadesGate;

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
        Paginator::useBootstrap();


        FacadesGate::define('admin', function(User $user){
            return $user->is_admin;        
        });
        
        FacadesGate::define('superadmin', function(User $user){
            return $user->is_superadmin;
        });
    }
}
