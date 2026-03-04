<?php

namespace LaraChain\Messages;

/**
 * Class SystemMessage
 *
 * Represents a system prompt/message.
 */
class SystemMessage extends BaseMessage
{
    /**
     * Get the role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return 'system';
    }
}
