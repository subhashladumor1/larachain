<?php

namespace LaraChain\Tools;

use LaraChain\Contracts\ToolInterface;

/**
 * Class Tool
 *
 * Base implementation for an agent tool.
 */
abstract class Tool implements ToolInterface
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $description;

    /**
     * Get the name of the tool.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Run the underlying logic of the tool with given input.
     *
     * @param array $input
     * @return mixed
     */
    abstract public function run(array $input): mixed;
}
