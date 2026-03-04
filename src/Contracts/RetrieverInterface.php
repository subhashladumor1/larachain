<?php

namespace LaraChain\Contracts;

/**
 * Interface RetrieverInterface
 *
 * Defines the contract to retrieve documents.
 */
interface RetrieverInterface
{
    /**
     * Get relevant documents based on the query.
     *
     * @param string $query
     * @return array<int, mixed>
     */
    public function getRelevantDocuments(string $query): array;
}
