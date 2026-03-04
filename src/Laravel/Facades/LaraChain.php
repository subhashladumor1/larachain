<?php

namespace LaraChain\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use LaraChain\Agents\AgentExecutor;

/**
 * @method static AgentExecutor agent()
 *
 * @see \LaraChain\Laravel\LaraChainManager
 */
class LaraChain extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'larachain';
    }
}
