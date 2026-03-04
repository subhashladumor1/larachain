<?php

namespace LaraChain\Chains;

use LaraChain\Contracts\ChainInterface;

/**
 * Class BaseChain
 *
 * Base class for executable chains.
 */
abstract class BaseChain implements ChainInterface
{
    /**
     * Execute the chain logic.
     *
     * @param mixed $input
     * @return mixed
     */
    abstract public function execute(mixed $input): mixed;
}
