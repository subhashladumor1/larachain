<?php

namespace LaraChain\Contracts;

/**
 * Interface ToolInterface
 *
 * Defines the contract for a tool that an agent can execute.
 */
interface ToolInterface
{
    /**
     * Get the name of the tool.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the description of the tool.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Run the tool with the given input.
     *
     * @param array $input
     * @return mixed
     */
    public function run(array $input): mixed;
}
