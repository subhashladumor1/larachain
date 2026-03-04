<?php

require __DIR__ . '/../vendor/autoload.php';

use LaraChain\Laravel\Facades\LaraChain;
use LaraChain\Memory\ConversationMemory;
use LaraChain\Toolkits\DatabaseToolkit;

echo "--- LaraChain Agent Example ---\n";

// Assuming Laravel AI SDK is configured in the environment
$agent = LaraChain::agent()
    ->tools((new DatabaseToolkit())->getTools())
    ->memory(new ConversationMemory());

echo "Executing query...\n";
$response = $agent->run("List all users in the 'users' table.");

echo "Agent Response:\n";
echo $response . "\n";
