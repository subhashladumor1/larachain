<?php

namespace LaraChain\Memory;

use LaraChain\Contracts\MemoryInterface;
use LaraChain\Contracts\MessageInterface;

/**
 * Class BufferMemory
 *
 * Stores the most recent N messages.
 */
class BufferMemory implements MemoryInterface
{
    /**
     * @var array<int, MessageInterface>
     */
    protected array $messages = [];

    protected int $limit;

    /**
     * BufferMemory constructor.
     *
     * @param int $limit Maximum number of messages to keep.
     */
    public function __construct(int $limit = 10)
    {
        $this->limit = $limit;
    }

    /**
     * Add a message to memory, respecting the buffer limit.
     *
     * @param MessageInterface $message
     * @return void
     */
    public function addMessage(MessageInterface $message): void
    {
        $this->messages[] = $message;

        if (count($this->messages) > $this->limit) {
            array_shift($this->messages);
        }
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
