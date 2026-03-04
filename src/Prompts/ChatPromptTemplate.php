<?php

namespace LaraChain\Prompts;

use LaraChain\Contracts\MessageInterface;

/**
 * Class ChatPromptTemplate
 *
 * Generates an array of messages dynamically.
 */
class ChatPromptTemplate
{
    /** @var array<int, array{string, string}> */
    protected array $messagesTemplate;

    /**
     * @param array<int, array{string, string}> $messagesTemplate Array of [Role, TemplateString]
     */
    public function __construct(array $messagesTemplate)
    {
        $this->messagesTemplate = $messagesTemplate;
    }

    /**
     * Render the messages based on variables.
     *
     * @param array<string, string> $variables
     * @return array<int, array{role: string, content: string}>
     */
    public function render(array $variables = []): array
    {
        $messages = [];

        foreach ($this->messagesTemplate as [$role, $templateString]) {
            $template = PromptTemplate::make($templateString);
            $messages[] = [
                'role' => $role,
                'content' => $template->render($variables),
            ];
        }

        return $messages;
    }
}
