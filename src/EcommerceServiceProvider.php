<?php

namespace Solimap\Ecommerce;

use Illuminate\Support\ServiceProvider;

class EcommerceServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/solimap.php', 'solimap');

        $this->app->singleton(Ecommerce::class, function () {
            return new Ecommerce();
        });

    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'solimap');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->publishes([
            __DIR__ . '/../config/solimap.php' => config_path('solimap.php'),
        ], 'solimap-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/solimap'),
        ], 'solimap-views');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/solimap'),
        ], 'solimap-assets');
    }
}
