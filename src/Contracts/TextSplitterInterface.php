<?php

namespace LaraChain\Contracts;

/**
 * Interface TextSplitterInterface
 *
 * Defines the contract for splitting text into smaller chunks.
 */
interface TextSplitterInterface
{
    /**
     * Split a single text into multiple chunks.
     *
     * @param string $text
     * @return array<int, string>
     */
    public function splitText(string $text): array;

    /**
     * Split an array of texts into multiple chunks.
     *
     * @param array<int, string> $texts
     * @return array<int, string>
     */
    public function splitTexts(array $texts): array;
}
