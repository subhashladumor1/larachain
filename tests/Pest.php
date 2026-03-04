<?php

uses(\LaraChain\Tests\TestCase::class)->in('Feature', 'Unit');

afterEach(function () {
    Mockery::close();
});
