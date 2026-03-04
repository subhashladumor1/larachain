<?php

namespace LaraChain\Messages;

use LaraChain\Contracts\MessageInterface;

abstract class BaseMessage implements MessageInterface
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    abstract public function getRole(): string;
}
