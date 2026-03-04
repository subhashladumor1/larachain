<?php

namespace LaraChain\Contracts;

/**
 * Interface DocumentLoaderInterface
 *
 * Defines the contract for document loaders.
 */
interface DocumentLoaderInterface
{
    /**
     * Load documents from a source.
     *
     * @return array<int, array{content: string, metadata: array<string, mixed>}>
     */
    public function load(): array;
}
