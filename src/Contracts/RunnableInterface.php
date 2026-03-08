<?php

namespace LaraChain\Contracts;

/**
 * Interface RunnableInterface
 *
 * Defines the contract for components that can be piped.
 */
interface RunnableInterface
{
    /**
     * Run the component with the given input.
     *
     * @param mixed $input
     * @return mixed
     */
    public function invoke(mixed $input): mixed;

    /**
     * Pipe this component into another runnable.
     *
     * @param RunnableInterface $next
     * @return RunnableInterface
     */
    public function pipe(RunnableInterface $next): RunnableInterface;
}
