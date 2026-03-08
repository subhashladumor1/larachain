<?php

namespace LaraChain\TextSplitters;

/**
 * Class RecursiveCharacterTextSplitter
 *
 * Implementation of a recursive character-based text splitter.
 * It tries to split text by a list of separators in order.
 */
class RecursiveCharacterTextSplitter extends TextSplitter
{
    protected array $separators;

    /**
     * Constructor.
     *
     * @param array<int, string>|null $separators
     * @param int $chunkSize
     * @param int $chunkOverlap
     */
    public function __construct(
        array $separators = null,
        int $chunkSize = 1000,
        int $chunkOverlap = 200
    ) {
        parent::__construct($chunkSize, $chunkOverlap);
        $this->separators = $separators ?? ["\n\n", "\n", " ", ""];
    }

    /**
     * Split a single text into chunks.
     *
     * @param string $text
     * @return array<int, string>
     */
    public function splitText(string $text): array
    {
        return $this->recursiveSplit($text, $this->separators);
    }

    /**
     * Recursively split text based on separators.
     *
     * @param string $text
     * @param array<int, string> $separators
     * @return array<int, string>
     */
    protected function recursiveSplit(string $text, array $separators): array
    {
        $finalChunks = [];
        $separator = "";
        $newSeparators = [];

        foreach ($separators as $i => $s) {
            if ($s === "") {
                $separator = $s;
                break;
            }
            if (str_contains($text, $s)) {
                $separator = $s;
                $newSeparators = array_slice($separators, $i + 1);
                break;
            }
        }

        if ($separator !== "") {
            $splits = explode($separator, $text);
        } else {
            $splits = [$text];
        }

        $goodSplits = [];
        foreach ($splits as $s) {
            if (strlen($s) < $this->chunkSize) {
                $goodSplits[] = $s;
            } else {
                if ($goodSplits) {
                    $merged = $this->joinDocs($goodSplits, $separator);
                    $finalChunks = array_merge($finalChunks, $merged);
                    $goodSplits = [];
                }
                if (!$newSeparators) {
                    $finalChunks[] = $s;
                } else {
                    $recursiveChunks = $this->recursiveSplit($s, $newSeparators);
                    $finalChunks = array_merge($finalChunks, $recursiveChunks);
                }
            }
        }

        if ($goodSplits) {
            $merged = $this->joinDocs($goodSplits, $separator);
            $finalChunks = array_merge($finalChunks, $merged);
        }

        return $finalChunks;
    }
}
