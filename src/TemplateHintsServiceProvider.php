<?php

namespace Flyke\TemplateHints;

use Illuminate\Support\ServiceProvider;

class TemplateHintsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Contracts\Http\Kernel $kernel)
    {
        $this->publishes([
            __DIR__.'/../config/templatehints.php' => config_path('templatehints.php'),
        ]);

        $tracer = (new TemplateHints)->trace();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/templatehints.php', 'tracer');
        $this->app->make('Flyke\TemplateHints\TemplateHints');
    }
}
