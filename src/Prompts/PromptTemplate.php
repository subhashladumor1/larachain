<?php

namespace LaraChain\Prompts;

use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class PromptTemplate
 *
 * Handles template variables for simple text prompts.
 */
class PromptTemplate implements RunnableInterface
{
    use HasPipe;
    protected string $template;

    /**
     * PromptTemplate constructor.
     *
     * @param string $template
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     * Make a new template instance.
     *
     * @param string $template
     * @return self
     */
    public static function make(string $template): self
    {
        return new self($template);
    }

    /**
     * Render the template with the provided variables.
     *
     * @param array<string, string> $variables
     * @return string
     * @throws \InvalidArgumentException If a required variable is missing.
     */
    public function render(array $variables = []): string
    {
        // Extract required placeholders from template (e.g., {topic})
        preg_match_all('/\{([^}]+)\}/', $this->template, $matches);
        $requiredVars = $matches[1];

        foreach ($requiredVars as $var) {
            if (!isset($variables[$var])) {
                throw new \InvalidArgumentException("Missing required placeholder variable: {$var}");
            }
        }

        $rendered = $this->template;
        foreach ($variables as $key => $value) {
            $rendered = str_replace("{{$key}}", $value, $rendered);
        }

        return $rendered;
    }
}
