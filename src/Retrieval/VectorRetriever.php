<?php

namespace LaraChain\Retrieval;

use LaraChain\VectorStores\InMemoryVectorStore;

/**
 * Class VectorRetriever
 *
 * Retrieves documents using a VectorStore.
 */
class VectorRetriever extends Retriever
{
    protected InMemoryVectorStore $vectorStore;
    protected int $k;

    /**
     * @param InMemoryVectorStore $vectorStore
     * @param int $k Amount of documents to retrieve
     */
    public function __construct(InMemoryVectorStore $vectorStore, int $k = 4)
    {
        $this->vectorStore = $vectorStore;
        $this->k = $k;
    }

    /**
     * 1. Embed query
     * 2. Search vector store
     * 3. Return relevant documents
     *
     * @param string $query
     * @return array<int, mixed>
     */
    public function getRelevantDocuments(string $query): array
    {
        return $this->vectorStore->similaritySearch($query, $this->k);
    }
}
