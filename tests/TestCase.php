<?php

namespace LaraChain\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use LaraChain\Laravel\AIServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            \Prism\Prism\PrismServiceProvider::class,
            \Laravel\Ai\AiServiceProvider::class,
            AIServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('ai.default', 'openai');
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaraChain' => \LaraChain\Laravel\Facades\LaraChain::class,
        ];
    }
}
