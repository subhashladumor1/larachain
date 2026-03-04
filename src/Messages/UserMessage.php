<?php

namespace LaraChain\Messages;

/**
 * Class UserMessage
 *
 * Represents a user prompt/message.
 */
class UserMessage extends BaseMessage
{
    /**
     * Get the role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return 'user';
    }
}
