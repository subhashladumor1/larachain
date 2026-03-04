<?php

namespace LaraChain\Contracts;

/**
 * Interface ToolkitInterface
 *
 * Defines the contract for an agent toolkit to group tools together.
 */
interface ToolkitInterface
{
    /**
     * Get the available tools in the toolkit.
     *
     * @return array<int, string|ToolInterface>
     */
    public function getTools(): array;
}
