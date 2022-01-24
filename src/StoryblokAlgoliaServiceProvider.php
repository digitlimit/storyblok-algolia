<?php

namespace Digitlimit\StoryblokAlgolia;

use Illuminate\Support\ServiceProvider;

class StoryblokAlgoliaServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'digitlimit');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'digitlimit');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/storyblok-algolia.php', 'storyblok-algolia');

        // Register the service the package provides.
        $this->app->singleton('storyblok-algolia', function ($app) {
            return new StoryblokAlgolia;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['storyblok-algolia'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/storyblok-algolia.php' => config_path('storyblok-algolia.php'),
        ], 'storyblok-algolia.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/digitlimit'),
        ], 'storyblok-algolia.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/digitlimit'),
        ], 'storyblok-algolia.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/digitlimit'),
        ], 'storyblok-algolia.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
