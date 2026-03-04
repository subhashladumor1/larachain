<?php

require __DIR__ . '/../vendor/autoload.php';

use LaraChain\Chains\SequentialChain;
use LaraChain\Chains\LLMChain;
use LaraChain\Prompts\PromptTemplate;

echo "--- LaraChain Chains Example ---\n";

$summarizePrompt = PromptTemplate::make('Summarize this text in one sentence: {input}');
$summarizeChain = new LLMChain($summarizePrompt);

$translatePrompt = PromptTemplate::make('Translate the following into French: {input}');
$translateChain = new LLMChain($translatePrompt);

$chain = SequentialChain::make()
    ->step($summarizeChain)
    ->step($translateChain);

echo "Running Sequential Chain...\n";
// Result would summarize then translate
$result = $chain->run("The LaraChain framework is a powerful AI tool for PHP developers using the Laravel ecosystem.");

echo "Chain Result:\n";
echo $result . "\n";
