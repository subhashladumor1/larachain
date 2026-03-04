<?php

namespace LaraChain\Tools;

use LaraChain\Contracts\ToolInterface;
use InvalidArgumentException;

/**
 * Class ToolRegistry
 *
 * Handles dynamic registration of tools for agents.
 */
class ToolRegistry
{
    /**
     * @var array<string, class-string<ToolInterface>|ToolInterface>
     */
    protected static array $tools = [];

    /**
     * Register a tool.
     *
     * @param string|ToolInterface $tool Tool class name or instance
     * @return void
     */
    public static function register(string|ToolInterface $tool): void
    {
        if (is_string($tool)) {
            // Validate that the string is a valid class that implements ToolInterface
            if (!class_exists($tool) || !is_subclass_of($tool, ToolInterface::class)) {
                throw new InvalidArgumentException("Tool class must implement ToolInterface.");
            }

            // Instantiate to get the name
            /** @var ToolInterface $instance */
            $instance = new $tool();
            self::$tools[$instance->getName()] = $tool;
            return;
        }

        self::$tools[$tool->getName()] = $tool;
    }

    /**
     * Get a specific registered tool by name.
     *
     * @param string $name
     * @return ToolInterface|null
     */
    public static function get(string $name): ?ToolInterface
    {
        if (!isset(self::$tools[$name])) {
            return null;
        }

        $tool = self::$tools[$name];

        return is_string($tool) ? new $tool() : $tool;
    }

    /**
     * Get all registered tools.
     *
     * @return array<string, class-string<ToolInterface>|ToolInterface>
     */
    public static function all(): array
    {
        return self::$tools;
    }

    /**
     * Clear the registry
     * 
     * @return void
     */
    public static function clear(): void
    {
        self::$tools = [];
    }
}
