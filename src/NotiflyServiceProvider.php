<?php

namespace Piscibus\Notifly;

use Illuminate\Support\ServiceProvider;

class NotiflyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishConfigs();

            $this->publishViews();

            $this->publishMigrations();

            $this->bootCommands();
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'notifly');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/notifly.php', 'notifly');
    }

    private function publishConfigs(): void
    {
        $this->publishes([
            __DIR__ . '/../config/notifly.php' => config_path('notifly.php'),
        ], 'config');
    }

    private function publishViews(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/notifly'),
        ], 'views');
    }

    private function publishMigrations(): void
    {
        $files = [
            'create_notifly_notification_table.php',
            'create_notifly_read_notification_table.php',
            'create_notifly_notification_actor_table.php',
        ];
        $paths = [];
        foreach ($files as $fileName) {
            $stubName = __DIR__ . '/../database/migrations/' . $fileName . '.stub';
            $datePrefix = date('Y_m_d_His', time());
            $migrationPath = database_path('migrations/' . $datePrefix . '_' . $fileName);
            $paths[$stubName] = $migrationPath;
        }
        $this->publishes($paths, 'migrations');
    }

    private function bootCommands(): void
    {
        $this->commands([

        ]);
    }
}
