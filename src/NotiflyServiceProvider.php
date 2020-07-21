<?php

namespace Piscibus\Notifly;

use Illuminate\Support\ServiceProvider;
use Piscibus\Notifly\Commands\NotiflyCommand;

class NotiflyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/notifly.php' => config_path('notifly.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/notifly'),
            ], 'views');

            if (! class_exists('CreatePackageTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_notifly_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_notifly_table.php'),
                ], 'migrations');
            }

            $this->commands([
                NotiflyCommand::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'notifly');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/notifly.php', 'notifly');
    }
}
