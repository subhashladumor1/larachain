<?php

namespace LaraChain\Laravel;

use Illuminate\Support\ServiceProvider;
use LaraChain\Agents\AgentExecutor;

class AIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/larachain.php',
            'larachain'
        );

        $this->app->singleton('larachain', function ($app) {
            return new LaraChainManager($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/larachain.php' => config_path('larachain.php'),
        ], 'larachain-config');
    }
}

/**
 * Class LaraChainManager
 * Allows facade-based access to the framework.
 */
class LaraChainManager
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get an agent instance.
     *
     * @return \LaraChain\Agents\AgentExecutor
     */
    public function agent(): AgentExecutor
    {
        return AgentExecutor::make();
    }
}
