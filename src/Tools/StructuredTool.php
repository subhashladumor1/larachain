<?php

namespace LaraChain\Tools;

/**
 * Class StructuredTool
 *
 * Supports tools with a JSON schema for their parameters.
 */
abstract class StructuredTool extends Tool
{
    /**
     * Defines the argument schema for the tool.
     *
     * @return array<string, mixed>
     */
    abstract public function getSchema(): array;
}
