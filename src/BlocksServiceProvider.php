<?php

namespace AwStudio\Blocks;

use Illuminate\Support\ServiceProvider;

class BlocksServiceProvider extends ServiceProvider
{
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
