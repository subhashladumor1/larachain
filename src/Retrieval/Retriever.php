<?php

namespace LaraChain\Retrieval;

use LaraChain\Contracts\RetrieverInterface;

/**
 * Class Retriever
 *
 * Base class for retrieving information.
 */
abstract class Retriever implements RetrieverInterface
{
    /**
     * Get relevant documents based on the query.
     *
     * @param string $query
     * @return array<int, mixed>
     */
    abstract public function getRelevantDocuments(string $query): array;
}
