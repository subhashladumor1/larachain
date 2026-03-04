<?php

namespace LaraChain\Contracts;

/**
 * Interface MessageInterface
 *
 * Represents a structured message in a conversation.
 */
interface MessageInterface
{
    /**
     * Get the content of the message.
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get the role of the message sender (e.g., system, user, assistant).
     *
     * @return string
     */
    public function getRole(): string;
}
