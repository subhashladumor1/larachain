<?php

namespace LaraChain\Contracts;

/**
 * Interface EmbeddingInterface
 *
 * Contract for a model that generates embeddings.
 */
interface EmbeddingInterface
{
    /**
     * Embed a piece of text.
     *
     * @param string $text
     * @return array<int, float>
     */
    public function embedQuery(string $text): array;

    /**
     * Embed a list of documents.
     *
     * @param array<int, string> $texts
     * @return array<int, array<int, float>>
     */
    public function embedDocuments(array $texts): array;
}
