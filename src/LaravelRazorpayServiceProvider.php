<?php

namespace TheTestCoder\LaravelRazorpay;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Razorpay\Api\Api;

class LaravelRazorpayServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-razorpay.php', 'laravel-razorpay');

        // Register the main class to use with the facade
        $this->app->singleton(LaravelRazorpay::class, function () {
            $apiKey = Config::get('laravel-razorpay.api_key');
            $apiSecret = Config::get('laravel-razorpay.api_secret');
            $api = new Api($apiKey, $apiSecret);

            return new LaravelRazorpay($api);
        });

        $this->app->singleton('laravel-razorpay', function () {
            $apiKey = Config::get('laravel-razorpay.api_key');
            $apiSecret = Config::get('laravel-razorpay.api_secret');
            $api = new Api($apiKey, $apiSecret);

            return new LaravelRazorpay($api);
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        // Use When you need to load assets
        //        $this
        //            ->loadMigrations()
        //            ->loadTranslations()
        //            ->loadRoutes()
        //            ->registerPublishes()
        //            ->registerCommands();

        $this->loadViews();

        $this
            ->registerPublishes()
            ->registerCommands();
    }

    /**
     * @description method that register multiple publishes
     * @return $this
     */
    private function registerPublishes(): self
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . './config/structure.php' => config_path('laravel-razorpay.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . './resources/views' => resource_path('views/vendor/laravel-razorpay'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . './resources/assets' => public_path('vendor/laravel-razorpay'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . './resources/lang' => resource_path('lang/vendor/laravel-razorpay'),
            ], 'lang');
        }

        return $this;
    }

    /**
     * @description method that register commands
     * @return $this
     */
    private function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([]);
        }

        return $this;
    }

    /**
     * @description method that load views
     * @return $this
     */
    private function loadViews(): self
    {
        $this->loadViewsFrom(__DIR__ . './resources/views', 'laravel-razorpay');

        return $this;
    }

    /**
     * @description method that load translation
     * @return $this
     */
    private function loadTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__ . './resources/lang', 'laravel-razorpay');

        return $this;
    }

    /**
     * @description method that load migration
     * @return $this
     */
    private function loadMigrations(): self
    {
        $this->loadMigrationsFrom(__DIR__ . './database/migrations');

        return $this;
    }

    /**
     * @description method that load routes
     * @return $this
     */
    private function loadRoutes(): self
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        return $this;
    }
}
