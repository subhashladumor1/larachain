<?php

use LaraChain\Agents\AgentExecutor;
use LaraChain\Memory\BufferMemory;
use Illuminate\Support\Facades\Facade;

class FauxAiResponse
{
    protected $text;
    public function __construct($text)
    {
        $this->text = $text;
    }
    public function __toString()
    {
        return $this->text;
    }
}

test('agent executor reasoning loop stops on final answer', function () {
    \Prism\Prism\Facades\Prism::fake([
        \Prism\Prism\Testing\TextResponseFake::make()->withText("Action: test_tool\nAction Input: {\"query\": \"test\"}"),
        \Prism\Prism\Testing\TextResponseFake::make()->withText('Final Answer: This is the result.')
    ]);

    $tool = new class extends \LaraChain\Tools\Tool {
        protected string $name = 'test_tool';
        protected string $description = 'A test tool.';
        public function run(array $input): mixed
        {
            return "Tool executed.";
        }
    };

    $memory = new BufferMemory(5);
    $agent = AgentExecutor::make()
        ->tools([$tool])
        ->memory($memory);

    $result = $agent->run("Hello Agent!");

    expect($result)->toBe("This is the result.");

    // Check memory stored the messages
    $messages = $memory->getMessages();
    expect($messages)->toHaveCount(2) // UserMessage, AssistantMessage
        ->and($messages[1]->getContent())->toBe("This is the result.");
});
