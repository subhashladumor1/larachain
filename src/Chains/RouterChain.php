<?php

namespace LaraChain\Chains;

use LaraChain\Contracts\ChainInterface;

/**
 * Class RouterChain
 *
 * Routes a task dynamically to a specific chain based on input semantics using an LLM.
 */
class RouterChain extends BaseChain
{
    /** @var array<string, array{description: string, chain: class-string<ChainInterface>|ChainInterface}> */
    protected array $routes = [];
    protected ?ChainInterface $defaultChain = null;

    /**
     * Add a route.
     *
     * @param string $name Route identifier
     * @param string $description What the route handles
     * @param string|ChainInterface $chain The target chain
     * @return self
     */
    public function addRoute(string $name, string $description, string|ChainInterface $chain): self
    {
        $this->routes[$name] = [
            'description' => $description,
            'chain' => $chain
        ];
        return $this;
    }

    /**
     * Set a default chain if no routes match.
     *
     * @param string|ChainInterface $chain
     * @return self
     */
    public function setDefaultRoute(string|ChainInterface $chain): self
    {
        $this->defaultChain = is_string($chain) ? new $chain() : $chain;
        return $this;
    }

    /**
     * Route the input dynamically and execute the chosen chain.
     *
     * @param string|array $input
     * @return mixed
     */
    public function execute(mixed $input): mixed
    {
        $textInput = is_array($input) ? json_encode($input) : (string) $input;

        $routeDescriptions = implode("\n", array_map(function ($name, $route) {
            return "- {$name}: {$route['description']}";
        }, array_keys($this->routes), $this->routes));

        $prompt = <<<PROMPT
Given the following user input, decide which of these routes is most appropriate to handle it:
{$routeDescriptions}

Input: {$textInput}
Output the exact route name only. If nothing fits, output "DEFAULT".
PROMPT;

        // Use AI SDK to determine route
        $responseObject = \Laravel\Ai\agent()->prompt(
            $prompt,
            model: config('larachain.default_model', 'gpt-4o')
        );

        $response = $responseObject->text ?? (string) $responseObject;
        $chosenRoute = trim($response);

        if (isset($this->routes[$chosenRoute])) {
            $chainClassOrInstance = $this->routes[$chosenRoute]['chain'];
            $chain = is_string($chainClassOrInstance) ? new $chainClassOrInstance() : $chainClassOrInstance;
            return $chain->execute($input);
        }

        if ($this->defaultChain) {
            return $this->defaultChain->execute($input);
        }

        throw new \Exception("No matching route found and no default route set.");
    }
}
