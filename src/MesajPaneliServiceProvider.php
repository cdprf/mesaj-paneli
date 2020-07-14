<?php

namespace hkntrksy\MesajPaneli;

use Illuminate\Support\ServiceProvider;


class MesajPaneliServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

    }

    /**
     * Publishes the configuration files for the package.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $this->publishes([
            __DIR__.'/../config/mesaj-paneli.php' => config_path('mesaj-paneli.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/mesaj-paneli.php', 'mesaj-paneli');
    }

}
