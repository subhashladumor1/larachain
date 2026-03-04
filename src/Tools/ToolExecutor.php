<?php

namespace LaraChain\Tools;

/**
 * Class ToolExecutor
 *
 * Executes tool calls requested by an agent.
 */
class ToolExecutor
{
    /**
     * Execute a tool by name with arguments.
     *
     * @param string $toolName
     * @param array<string, mixed> $arguments
     * @return mixed
     * @throws \Exception
     */
    public function execute(string $toolName, array $arguments): mixed
    {
        $tool = ToolRegistry::get($toolName);

        if (!$tool) {
            throw new \Exception("Tool [{$toolName}] not found in registry.");
        }

        return $tool->run($arguments);
    }
}
