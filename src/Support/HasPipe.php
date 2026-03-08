<?php

namespace LaraChain\Support;

use LaraChain\Contracts\RunnableInterface;
use LaraChain\Chains\RunnableSequence;

/**
 * Trait HasPipe
 *
 * Provides piping functionality to components.
 */
trait HasPipe
{
    /**
     * Pipe this component into another runnable.
     *
     * @param RunnableInterface $next
     * @return RunnableInterface
     */
    public function pipe(RunnableInterface $next): RunnableInterface
    {
        return new RunnableSequence($this, $next);
    }

    /**
     * Alias for invoke to stay compatible with existing execute() methods.
     *
     * @param mixed $input
     * @return mixed
     */
    public function invoke(mixed $input): mixed
    {
        if (method_exists($this, 'execute')) {
            return $this->execute($input);
        }

        if (method_exists($this, 'render')) {
            return $this->render($input);
        }

        if (method_exists($this, 'parse')) {
            return $this->parse($input);
        }

        if (method_exists($this, 'getRelevantDocuments')) {
            return $this->getRelevantDocuments($input);
        }

        throw new \Exception("Component " . get_class($this) . " does not implement a valid execution method.");
    }
}
