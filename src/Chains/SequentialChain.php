<?php

namespace LaraChain\Chains;

use LaraChain\Contracts\ChainInterface;

/**
 * Class SequentialChain
 *
 * Runs multiple chains sequentially.
 */
class SequentialChain extends BaseChain
{
    /** @var array<int, class-string<ChainInterface>|ChainInterface> */
    protected array $chains = [];

    /**
     * Create a new sequential chain instance.
     *
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * Add a chain step.
     *
     * @param class-string<ChainInterface>|ChainInterface $chain
     * @return self
     */
    public function step(string|ChainInterface $chain): self
    {
        $this->chains[] = $chain;
        return $this;
    }

    /**
     * Run the sequential chain, passing output to the next step.
     *
     * @param mixed $input
     * @return mixed
     */
    public function execute(mixed $input): mixed
    {
        return $this->run($input);
    }

    /**
     * Alias for execute() to support elegant builder syntax.
     *
     * @param mixed $input
     * @return mixed
     */
    public function run(mixed $input): mixed
    {
        $currentInput = $input;

        foreach ($this->chains as $chainDefinition) {
            /** @var ChainInterface $chain */
            $chain = is_string($chainDefinition) ? new $chainDefinition() : $chainDefinition;
            $currentInput = $chain->execute($currentInput);
        }

        return $currentInput;
    }
}
