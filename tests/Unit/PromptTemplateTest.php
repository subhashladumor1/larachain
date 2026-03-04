<?php

use LaraChain\Prompts\PromptTemplate;
use LaraChain\Prompts\ChatPromptTemplate;

test('it renders a simple prompt template', function () {
    $template = PromptTemplate::make('Explain {topic} in {language}');
    $rendered = $template->render(['topic' => 'queues', 'language' => 'PHP']);

    expect($rendered)->toBe('Explain queues in PHP');
});

test('it throws exception on missing variable', function () {
    $template = PromptTemplate::make('Explain {topic}');
    $template->render([]);
})->throws(InvalidArgumentException::class, 'Missing required placeholder variable: topic');

test('it renders chat prompt template', function () {
    $template = new ChatPromptTemplate([
        ['system', 'You are a helpful assistant.'],
        ['user', 'Tell me about {topic}'],
    ]);

    $messages = $template->render(['topic' => 'Laravel']);

    expect($messages)->toHaveCount(2)
        ->and($messages[0]['role'])->toBe('system')
        ->and($messages[1]['content'])->toBe('Tell me about Laravel');
});
