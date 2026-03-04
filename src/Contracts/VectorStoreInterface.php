<?php

namespace LaraChain\Contracts;

/**
 * Interface VectorStoreInterface
 *
 * Defines the contract for a vector store.
 */
interface VectorStoreInterface
{
    /**
     * Add expected texts and their embeddings to the store.
     *
     * @param array<int, string> $texts
     * @param array<int, array<int, float>> $embeddings
     * @param array<int, array<string, mixed>> $metadatas
     * @return void
     */
    public function addTexts(array $texts, array $embeddings, array $metadatas = []): void;

    /**
     * Perform a similarity search.
     *
     * @param array<int, float> $queryEmbedding
     * @param int $k
     * @return array<int, array<string, mixed>>
     */
    public function similaritySearchVectorWithScore(array $queryEmbedding, int $k = 4): array;
}
