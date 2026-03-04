<?php

namespace LaraChain\Parsers;

/**
 * Interface OutputParserInterface
 */
interface OutputParserInterface
{
    /**
     * Parse the raw string output from the LLM into a structured format.
     *
     * @param string $text
     * @return mixed
     */
    public function parse(string $text): mixed;
}
