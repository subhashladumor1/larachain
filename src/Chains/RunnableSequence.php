<?php

namespace LaraChain\Chains;

use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class RunnableSequence
 *
 * Chains two runnables together.
 */
class RunnableSequence implements RunnableInterface
{
    use HasPipe;

    protected RunnableInterface $first;
    protected RunnableInterface $second;

    /**
     * RunnableSequence constructor.
     *
     * @param RunnableInterface $first
     * @param RunnableInterface $second
     */
    public function __construct(RunnableInterface $first, RunnableInterface $second)
    {
        $this->first = $first;
        $this->second = $second;
    }

    /**
     * Invoke the sequence.
     *
     * @param mixed $input
     * @return mixed
     */
    public function invoke(mixed $input): mixed
    {
        $firstOutput = $this->first->invoke($input);
        return $this->second->invoke($firstOutput);
    }
}
