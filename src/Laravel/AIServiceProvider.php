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

        $this->app->singleton(\LaraChain\Embeddings\EmbeddingManager::class, function ($app) {
            return new \LaraChain\Embeddings\EmbeddingManager($app);
        });

        $this->app->bind(\LaraChain\Contracts\EmbeddingInterface::class, function ($app) {
            return $app->make(\LaraChain\Embeddings\EmbeddingManager::class)->driver();
        });

        $this->app->singleton(\LaraChain\VectorStores\VectorStoreManager::class, function ($app) {
            return new \LaraChain\VectorStores\VectorStoreManager($app);
        });

        $this->app->bind(\LaraChain\Contracts\VectorStoreInterface::class, function ($app) {
            return $app->make(\LaraChain\VectorStores\VectorStoreManager::class)->driver();
        });

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
     * Get a ChatModel / LLM provider.
     *
     * @param string|null $driver
     * @return \LaraChain\Models\ChatModel
     */
    public function model(string $driver = null): \LaraChain\Models\ChatModel
    {
        $driver = $driver ?? config('larachain.default.llm');
        $config = config("larachain.llms.{$driver}");

        return new \LaraChain\Models\ChatModel(
            $config['model'] ?? null,
            $config['options'] ?? []
        );
    }

    /**
     * Access the Vector Store Manager.
     *
     * @return \LaraChain\VectorStores\VectorStoreManager
     */
    public function vectors(): \LaraChain\VectorStores\VectorStoreManager
    {
        return $this->app->make(\LaraChain\VectorStores\VectorStoreManager::class);
    }

    /**
     * Access the Embedding Manager.
     *
     * @return \LaraChain\Embeddings\EmbeddingManager
     */
    public function embeddings(): \LaraChain\Embeddings\EmbeddingManager
    {
        return $this->app->make(\LaraChain\Embeddings\EmbeddingManager::class);
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
