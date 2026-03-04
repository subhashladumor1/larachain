<?php

use LaraChain\Chains\RouterChain;
use LaraChain\Contracts\ChainInterface;
use Illuminate\Support\Facades\Facade;

class FauxRouterAiResponse
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

test('router chain dynamically selects chain', function () {
    \Prism\Prism\Facades\Prism::fake([
        \Prism\Prism\Testing\TextResponseFake::make()->withText('chain_b')
    ]);

    $chainA = new class implements ChainInterface {
        public function execute(mixed $input): mixed
        {
            return "Result A";
        }
    };

    $chainB = new class implements ChainInterface {
        public function execute(mixed $input): mixed
        {
            return "Result B";
        }
    };

    $router = new RouterChain();
    $router->addRoute('chain_a', 'Handles A tasks', $chainA);
    $router->addRoute('chain_b', 'Handles B tasks', $chainB);

    $result = $router->execute("Do B task");

    expect($result)->toBe("Result B");
});
