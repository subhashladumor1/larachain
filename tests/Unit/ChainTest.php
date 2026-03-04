<?php

use LaraChain\Chains\SequentialChain;
use LaraChain\Contracts\ChainInterface;

test('sequential chain executes chains in order', function () {
    $chain1 = new class implements ChainInterface {
        public function execute(mixed $input): mixed
        {
            return $input . " World";
        }
    };

    $chain2 = new class implements ChainInterface {
        public function execute(mixed $input): mixed
        {
            return strtoupper($input);
        }
    };

    $seqChain = SequentialChain::make()
        ->step($chain1)
        ->step($chain2);

    $result = $seqChain->run("Hello");

    expect($result)->toBe("HELLO WORLD");
});
