<?php

use LaraChain\Chains\LLMChain;
use LaraChain\Prompts\PromptTemplate;
use Illuminate\Support\Facades\Facade;

class FauxLLMResponse
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

test('llm chain execute prompts the ai', function () {
    \Prism\Prism\Facades\Prism::fake([
        \Prism\Prism\Testing\TextResponseFake::make()->withText('Hi there!')
    ]);

    $prompt = PromptTemplate::make('Hello {name}');
    $chain = new LLMChain($prompt, 'gpt-4o');

    $result = $chain->execute(['name' => 'LaraChain']);

    expect($result)->toBe("Hi there!");
});
