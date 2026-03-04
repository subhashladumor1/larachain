<?php

namespace LaraChain\Agents;

use LaraChain\Contracts\MemoryInterface;
use LaraChain\Tools\ToolExecutor;

/**
 * Class AgentExecutor
 *
 * Implements ReAct (Reasoning and Acting) execution loop.
 */
class AgentExecutor extends Agent
{
    protected ?MemoryInterface $memory = null;
    protected int $maxIterations = 5;

    /**
     * Create a new AgentExecutor instance.
     *
     * @return static
     */
    public static function make(): static
    {
        return new static();
    }

    /**
     * Set the memory instance.
     *
     * @param MemoryInterface $memory
     * @return self
     */
    public function memory(MemoryInterface $memory): self
    {
        $this->memory = $memory;
        return $this;
    }

    /**
     * Run the ReAct agent reasoning loop.
     * 1. Send prompt to Laravel AI SDK
     * 2. Detect tool request
     * 3. Execute tool
     * 4. Add observation
     * 5. Continue reasoning
     *
     * @param string $input
     * @return string
     */
    public function run(string $input): string
    {
        $memoryContext = '';
        if ($this->memory) {
            foreach ($this->memory->getMessages() as $msg) {
                $memoryContext .= ucfirst($msg->getRole()) . ": " . $msg->getContent() . "\n";
            }
        }

        $scratchpad = "";
        $executor = new ToolExecutor();

        for ($i = 0; $i < $this->maxIterations; $i++) {
            $prompt = $this->buildPrompt($input, $memoryContext, $scratchpad);

            // Using Laravel AI SDK
            $responseObject = \Laravel\Ai\agent()->prompt(
                $prompt,
                model: config('larachain.default_model', 'gpt-4o')
            );

            $response = $responseObject->text ?? (string) $responseObject;

            // Detect if a tool was requested (simple JSON regex parsing for ReAct)
            if ($toolRequest = $this->parseToolRequest($response)) {
                $toolName = $toolRequest['action'];
                $toolArgs = $toolRequest['action_input'];

                try {
                    $observation = $executor->execute($toolName, $toolArgs);
                } catch (\Exception $e) {
                    $observation = "Error executing tool: " . $e->getMessage();
                }

                $scratchpad .= "Thought: " . $response . "\nObservation: " . $observation . "\n";
            } else {
                // Determine if it reached the final answer
                $finalAnswer = $this->parseFinalAnswer($response);

                if ($this->memory) {
                    $this->memory->addMessage(new \LaraChain\Messages\UserMessage($input));
                    $this->memory->addMessage(new \LaraChain\Messages\AssistantMessage($finalAnswer));
                }

                return $finalAnswer;
            }
        }

        return "Agent stopped after reaching max iterations.";
    }

    /**
     * Build the ReAct prompt.
     */
    protected function buildPrompt(string $input, string $memoryContext, string $scratchpad): string
    {
        $toolDescriptions = implode("\n", array_map(function ($tool) {
            $toolInst = is_string($tool) ? new $tool() : $tool;
            return "- " . $toolInst->getName() . ": " . $toolInst->getDescription();
        }, $this->tools));

        return <<<PROMPT
Answer the following questions as best you can. You have access to the following tools:

{$toolDescriptions}

Use the following format:
Question: the input question you must answer
Thought: you should always think about what to do
Action: the action to take, should be one of the tool names
Action Input: the input to the action (in JSON format)
Observation: the result of the action
... (this Thought/Action/Action Input/Observation can repeat N times)
Thought: I now know the final answer
Final Answer: the final answer to the original input question

History:
{$memoryContext}

Question: {$input}
{$scratchpad}
PROMPT;
    }

    protected function parseToolRequest(string $response): ?array
    {
        if (preg_match('/Action: (.*?)\nAction Input: (\{.*?\})/s', $response, $matches)) {
            return [
                'action' => trim($matches[1]),
                'action_input' => json_decode(trim($matches[2]), true) ?? []
            ];
        }

        return null;
    }

    protected function parseFinalAnswer(string $response): string
    {
        if (preg_match('/Final Answer: (.*)/s', $response, $matches)) {
            return trim($matches[1]);
        }

        return $response; // Fallback
    }
}
