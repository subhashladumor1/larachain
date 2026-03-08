<?php

namespace LaraChain\Models;

use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class ChatModel
 *
 * A runnable wrapper for the Laravel AI SDK Chat/Agent capabilities.
 */
class ChatModel implements RunnableInterface
{
    use HasPipe;

    protected string $model;
    protected array $options;

    /**
     * ChatModel constructor.
     *
     * @param string|null $model
     * @param array $options
     */
    public function __construct(string $model = null, array $options = [])
    {
        $this->model = $model ?? config('larachain.default_model', 'gpt-4o');
        $this->options = $options;
    }

    /**
     * Invoke the model.
     *
     * @param mixed $input String prompt or array of messages
     * @return string
     */
    public function invoke(mixed $input): string
    {
        $options = array_merge(['model' => $this->model], $this->options);
        $response = \Laravel\Ai\agent()->prompt($input, ...$options);

        return $response->text ?? (string) $response;
    }
}
