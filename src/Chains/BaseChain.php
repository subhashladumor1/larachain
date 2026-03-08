<?php

namespace LaraChain\Chains;

use LaraChain\Contracts\ChainInterface;
use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class BaseChain
 *
 * Base class for executable chains.
 */
abstract class BaseChain implements ChainInterface, RunnableInterface
{
    use HasPipe;
    /**
     * Execute the chain logic.
     *
     * @param mixed $input
     * @return mixed
     */
    abstract public function execute(mixed $input): mixed;
}
