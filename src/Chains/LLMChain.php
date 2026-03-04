<?php

namespace LaraChain\Chains;

use LaraChain\Prompts\PromptTemplate;

/**
 * Class LLMChain
 *
 * A chain to execute a prompt template using Laravel AI SDK.
 */
class LLMChain extends BaseChain
{
    protected PromptTemplate $prompt;
    protected string $model;

    /**
     * LLMChain constructor.
     *
     * @param PromptTemplate $prompt
     * @param string $model
     */
    public function __construct(PromptTemplate $prompt, string $model = 'gpt-4o')
    {
        $this->prompt = $prompt;
        $this->model = $model;
    }

    /**
     * Execute the given input variables through the prompt template and AI model.
     *
     * @param array<string, string>|string $input
     * @return mixed
     */
    public function execute(mixed $input): mixed
    {
        if (is_string($input)) {
            $input = ['input' => $input];
        }

        $renderedPrompt = $this->prompt->render($input);

        $response = \Laravel\Ai\agent()->prompt($renderedPrompt, model: $this->model);

        return $response->text ?? (string) $response;
    }
}
