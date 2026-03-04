<?php

namespace LaraChain\Prompts;

/**
 * Class FewShotPromptTemplate
 *
 * Helps create a prompt with examples.
 */
class FewShotPromptTemplate
{
    protected string $prefix;
    protected string $suffix;
    protected PromptTemplate $exampleTemplate;
    /** @var array<int, array<string, string>> */
    protected array $examples;

    /**
     * @param string $prefix
     * @param string $suffix
     * @param PromptTemplate $exampleTemplate
     * @param array<int, array<string, string>> $examples
     */
    public function __construct(string $prefix, string $suffix, PromptTemplate $exampleTemplate, array $examples)
    {
        $this->prefix = $prefix;
        $this->suffix = $suffix;
        $this->exampleTemplate = $exampleTemplate;
        $this->examples = $examples;
    }

    /**
     * Format the few-shot prompt with input variables.
     *
     * @param array<string, string> $variables
     * @return string
     */
    public function render(array $variables = []): string
    {
        $pieces = [$this->prefix];

        foreach ($this->examples as $example) {
            $pieces[] = $this->exampleTemplate->render($example);
        }

        $suffixTemplate = PromptTemplate::make($this->suffix);
        $pieces[] = $suffixTemplate->render($variables);

        return implode("\n\n", $pieces);
    }
}
