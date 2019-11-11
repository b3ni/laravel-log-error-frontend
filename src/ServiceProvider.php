<?php

namespace Brarcos\LogErrorFrontend;

use Brarcos\LogErrorFrontend\Middleware\InjectJs;
use Illuminate\Contracts\Http\Kernel;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'brarcos');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'brarcos');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerMiddleware(InjectJs::class);

        $this->app['router']
            ->namespace('Brarcos\\LogErrorFrontend\\Controllers')
            ->middleware(['web'])
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/logerrorfrontend.php', 'logerrorfrontend');

        // Register the service the package provides.
        $this->app->singleton('logerrorfrontend', function ($app) {
            return new LogErrorFrontend();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['logerrorfrontend'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/logerrorfrontend.php' => config_path('logerrorfrontend.php'),
        ], 'logerrorfrontend.config');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Publishing the views.
        /*$this->publishes([
        __DIR__.'/../resources/views' => base_path('resources/views/vendor/brarcos'),
        ], 'logerrorfrontend.views');*/

        // Publishing assets.
        /*$this->publishes([
        __DIR__.'/../resources/assets' => public_path('vendor/brarcos'),
        ], 'logerrorfrontend.views');*/

        // Publishing the translation files.
        /*$this->publishes([
        __DIR__.'/../resources/lang' => resource_path('lang/vendor/brarcos'),
        ], 'logerrorfrontend.views');*/

        // Registering package commands.
        // $this->commands([]);
    }

    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }
}
