<?php

namespace LaraChain\Retrieval;

use LaraChain\Contracts\RetrieverInterface;
use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class Retriever
 *
 * Base class for retrieving information.
 */
abstract class Retriever implements RetrieverInterface, RunnableInterface
{
    use HasPipe;
    /**
     * Get relevant documents based on the query.
     *
     * @param string $query
     * @return array<int, mixed>
     */
    abstract public function getRelevantDocuments(string $query): array;
}
