<?php

namespace LaraChain\Agents;

use LaraChain\Contracts\AgentInterface;

/**
 * Class Agent
 *
 * Base implementation of an AI agent.
 */
abstract class Agent implements AgentInterface
{
    /**
     * Tools assigned to this agent.
     * @var array<int, string|\LaraChain\Contracts\ToolInterface>
     */
    protected array $tools = [];

    /**
     * Assign tools to the agent.
     *
     * @param array<int, string|\LaraChain\Contracts\ToolInterface> $tools
     * @return static
     */
    public function tools(array $tools): static
    {
        $this->tools = $tools;

        // Optionally register them if they aren't already
        foreach ($tools as $tool) {
            \LaraChain\Tools\ToolRegistry::register($tool);
        }

        return $this;
    }

    /**
     * Run the agent.
     *
     * @param string $input
     * @return mixed
     */
    abstract public function run(string $input): mixed;
}
