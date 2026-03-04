<?php

namespace LaraChain\Memory;

use LaraChain\Contracts\MemoryInterface;
use LaraChain\Contracts\MessageInterface;

/**
 * Class ConversationMemory
 *
 * Stores the full conversation history.
 */
class ConversationMemory implements MemoryInterface
{
    /**
     * @var array<int, MessageInterface>
     */
    protected array $messages = [];

    /**
     * Add a message to memory.
     *
     * @param MessageInterface $message
     * @return void
     */
    public function addMessage(MessageInterface $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * Get all messages.
     *
     * @return array<int, MessageInterface>
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Clear the memory.
     *
     * @return void
     */
    public function clear(): void
    {
        $this->messages = [];
    }
}
