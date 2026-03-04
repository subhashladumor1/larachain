<?php

namespace LaraChain\Embeddings;

use LaraChain\Contracts\EmbeddingInterface;

/**
 * Class EmbeddingModel
 *
 * Provides embedding generation using Laravel AI SDK.
 */
class EmbeddingModel implements EmbeddingInterface
{
    protected string $model;

    /**
     * EmbeddingModel constructor.
     *
     * @param string $model The embedding model configuration
     */
    public function __construct(string $model = 'text-embedding-3-small')
    {
        $this->model = config('larachain.default_embedding_model', $model);
    }

    /**
     * Embed a single query string.
     *
     * @param string $text
     * @return array<int, float>
     */
    public function embedQuery(string $text): array
    {
        $response = \Laravel\Ai\Embeddings::for([$text])
            ->generate(model: $this->model);

        return $response->embeddings[0] ?? [];
    }

    /**
     * Embed a list of documents.
     *
     * @param array<int, string> $texts
     * @return array<int, array<int, float>>
     */
    public function embedDocuments(array $texts): array
    {
        $response = \Laravel\Ai\Embeddings::for($texts)
            ->generate(model: $this->model);

        return $response->embeddings ?? [];
    }
}
