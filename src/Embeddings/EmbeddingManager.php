<?php

namespace LaraChain\Embeddings;

use Illuminate\Support\Manager;

/**
 * Class EmbeddingManager
 *
 * Manages various embedding model providers.
 */
class EmbeddingManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('larachain.default.embeddings', 'openai');
    }

    /**
     * Create an OpenAI embedding driver.
     *
     * @return EmbeddingModel
     */
    protected function createOpenaiDriver(): EmbeddingModel
    {
        $config = $this->config->get('larachain.embeddings.openai');
        return new EmbeddingModel($config['model']);
    }

    /**
     * Create a Gemini embedding driver.
     *
     * @return EmbeddingModel
     */
    protected function createGeminiDriver(): EmbeddingModel
    {
        $config = $this->config->get('larachain.embeddings.gemini') ?? ['model' => 'text-embedding-004'];
        return new EmbeddingModel($config['model']);
    }
}
