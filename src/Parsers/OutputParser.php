<?php

namespace LaraChain\Parsers;

use LaraChain\Contracts\RunnableInterface;
use LaraChain\Support\HasPipe;

/**
 * Class OutputParser
 *
 * Base class for output parsers.
 */
abstract class OutputParser implements OutputParserInterface, RunnableInterface
{
    use HasPipe;
    /**
     * Parse the raw string output from the LLM.
     *
     * @param string $text
     * @return mixed
     */
    abstract public function parse(string $text): mixed;
}
