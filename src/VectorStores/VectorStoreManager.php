<?php

namespace LaraChain\VectorStores;

use Illuminate\Support\Manager;
use LaraChain\Contracts\EmbeddingInterface;

/**
 * Class VectorStoreManager
 *
 * Manages various vector store drivers.
 */
class VectorStoreManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('larachain.default.vectorstore', 'memory');
    }

    /**
     * Create an instance of the In-Memory vector store driver.
     *
     * @return InMemoryVectorStore
     */
    protected function createMemoryDriver(): InMemoryVectorStore
    {
        return new InMemoryVectorStore(
            $this->container->make(EmbeddingInterface::class)
        );
    }

    /**
     * Create an instance of the Postgres vector store driver.
     *
     * @return PostgresVectorStore
     */
    protected function createPostgresDriver(): PostgresVectorStore
    {
        $config = $this->config->get('larachain.vectorstores.postgres');

        return new PostgresVectorStore(
            $this->container->make(EmbeddingInterface::class),
            $config['table'] ?? 'embeddings',
            $config['vector_column'] ?? 'embedding'
        );
    }
}
