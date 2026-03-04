<?php

namespace LaraChain\Messages;

/**
 * Class AssistantMessage
 *
 * Represents an assistant response/message.
 */
class AssistantMessage extends BaseMessage
{
    /**
     * Get the role.
     *
     * @return string
     */
    public function getRole(): string
    {
        return 'assistant';
    }
}
