<?php

namespace LaraChain\Contracts;

/**
 * Interface MemoryInterface
 *
 * Defines the contract for conversation memory storage.
 */
interface MemoryInterface
{
    /**
     * Add a message to the memory.
     *
     * @param MessageInterface $message
     * @return void
     */
    public function addMessage(MessageInterface $message): void;

    /**
     * Get all messages in memory.
     *
     * @return array<int, MessageInterface>
     */
    public function getMessages(): array;

    /**
     * Clear the memory.
     *
     * @return void
     */
    public function clear(): void;
}
