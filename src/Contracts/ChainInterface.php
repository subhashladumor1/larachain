<?php

namespace LaraChain\Contracts;

/**
 * Interface ChainInterface
 *
 * Defines the contract for an executable chain.
 */
interface ChainInterface
{
    /**
     * Execute the chain with the given input.
     *
     * @param mixed $input
     * @return mixed
     */
    public function execute(mixed $input): mixed;
}
