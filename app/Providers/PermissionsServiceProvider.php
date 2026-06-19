<?php

namespace App\Providers;

use App\StockUser;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            Blade::directive('role', function ($role) {
                return "<?php if(auth()->user()->hasRole($role)) : ?>";
            });

            Blade::directive('endrole', function ($role) {
                return "<?php endif; ?>";
            });
        });
    }
}
