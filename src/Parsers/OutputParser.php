<?php

namespace LaraChain\Parsers;

/**
 * Class OutputParser
 *
 * Base class for output parsers.
 */
abstract class OutputParser implements OutputParserInterface
{
    /**
     * Parse the raw string output from the LLM.
     *
     * @param string $text
     * @return mixed
     */
    abstract public function parse(string $text): mixed;
}
