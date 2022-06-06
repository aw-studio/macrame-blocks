<?php

namespace AwStudio\Blocks;

use Illuminate\Support\ServiceProvider;

class BlocksServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeBlocksCommand::class,
            ]);
        }
    }

    /**
     * Register application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MakeBlocksCommand::class, function ($app) {
            return new MakeBlocksCommand($app['files']);
        });
    }
}
