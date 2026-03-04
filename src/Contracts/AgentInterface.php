<?php

namespace LaraChain\Contracts;

/**
 * Interface AgentInterface
 *
 * Defines the contract for an AI agent.
 */
interface AgentInterface
{
    /**
     * Run the agent with the given input.
     *
     * @param string $input
     * @return mixed
     */
    public function run(string $input): mixed;
}
