<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

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
    Paginator::useBootstrapFive();
    Paginator::useBootstrapFour();
    DB::statement("SET time_zone='-04:00'");

    // Solo en entorno web, no en consola (ej: comandos Artisan)
    if (!$this->app->runningInConsole()) {
        $this->overridePublicPath();
    }
}

protected function overridePublicPath()
{
    App::bind('path.public', function () {
        return base_path('public_html'); // ← carpeta que usas en tu hosting
    });
}

}
