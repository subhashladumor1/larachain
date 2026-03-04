<?php

use LaraChain\Memory\ConversationMemory;
use LaraChain\Memory\BufferMemory;
use LaraChain\Messages\UserMessage;
use LaraChain\Messages\AssistantMessage;

test('conversation memory stores all messages', function () {
    $memory = new ConversationMemory();
    $memory->addMessage(new UserMessage('Hello'));
    $memory->addMessage(new AssistantMessage('Hi there!'));

    expect($memory->getMessages())->toHaveCount(2)
        ->and($memory->getMessages()[0]->getContent())->toBe('Hello')
        ->and($memory->getMessages()[1]->getRole())->toBe('assistant');
});

test('buffer memory respects the limit', function () {
    $memory = new BufferMemory(2);
    $memory->addMessage(new UserMessage('Msg 1'));
    $memory->addMessage(new UserMessage('Msg 2'));
    $memory->addMessage(new UserMessage('Msg 3'));

    $messages = $memory->getMessages();
    expect($messages)->toHaveCount(2)
        ->and($messages[0]->getContent())->toBe('Msg 2')
        ->and($messages[1]->getContent())->toBe('Msg 3');
});
