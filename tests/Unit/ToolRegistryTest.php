<?php

use LaraChain\Tools\ToolRegistry;
use LaraChain\Tools\Tool;

beforeEach(function () {
    ToolRegistry::clear();
});

test('it can register and retrieve a tool by class string', function () {
    $toolClass = new class extends Tool {
        protected string $name = 'test_tool';
        protected string $description = 'A test tool';
        public function run(array $input): mixed
        {
            return true;
        }
    };

    // Register anonymous class
    ToolRegistry::register(get_class($toolClass));

    $retrieved = ToolRegistry::get('test_tool');
    expect($retrieved)->not->toBeNull()
        ->and($retrieved->getName())->toBe('test_tool');
});

test('it can register a tool by instance', function () {
    $tool = new class extends Tool {
        protected string $name = 'instance_tool';
        protected string $description = 'Test instance tool';
        public function run(array $input): mixed
        {
            return true;
        }
    };

    ToolRegistry::register($tool);

    expect(ToolRegistry::get('instance_tool'))->not->toBeNull();
});

test('it throws exception for invalid tool registration', function () {
    ToolRegistry::register('stdClass');
})->throws(InvalidArgumentException::class, 'Tool class must implement ToolInterface.');
