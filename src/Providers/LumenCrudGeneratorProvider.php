<?php

namespace WRonX\LumenCrudGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use WRonX\LumenCrudGenerator\Commands\MakeCrudCommand;

class LumenCrudGeneratorProvider extends ServiceProvider
{
    public function boot() {
        $this->publishes([
                             __DIR__ . '/../../config/lumen-crud.php' => $this->config_path('lumen-crud.php'),
                         ]);
        
        if($this->app->runningInConsole()) {
            $this->commands([
                                MakeCrudCommand::class,
                            ]);
        }
    }
    
    private function config_path($path = '') {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
    
    public function register() {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/lumen-crud.php', 'lumen-crud'
        );
    
        $this->app->register(\Flipbox\LumenGenerator\LumenGeneratorServiceProvider::class);
    }
}