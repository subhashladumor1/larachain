<?php

namespace LaraChain\TextSplitters;

use LaraChain\Contracts\TextSplitterInterface;

/**
 * Class TextSplitter
 *
 * Base class for text splitters.
 */
abstract class TextSplitter implements TextSplitterInterface
{
    protected int $chunkSize;
    protected int $chunkOverlap;

    /**
     * Constructor.
     *
     * @param int $chunkSize
     * @param int $chunkOverlap
     */
    public function __construct(int $chunkSize = 1000, int $chunkOverlap = 200)
    {
        $this->chunkSize = $chunkSize;
        $this->chunkOverlap = $chunkOverlap;
    }

    /**
     * Split an array of texts.
     *
     * @param array<int, string> $texts
     * @return array<int, string>
     */
    public function splitTexts(array $texts): array
    {
        $chunks = [];
        foreach ($texts as $text) {
            $chunks = array_merge($chunks, $this->splitText($text));
        }
        return $chunks;
    }

    /**
     * Join segments while respecting chunk size and overlap.
     *
     * @param array<int, string> $segments
     * @param string $separator
     * @return array<int, string>
     */
    protected function joinDocs(array $segments, string $separator): array
    {
        $docs = [];
        $currentDoc = [];
        $totalLength = 0;

        foreach ($segments as $segment) {
            $segmentLength = strlen($segment);

            if ($totalLength + $segmentLength + (count($currentDoc) > 0 ? strlen($separator) : 0) > $this->chunkSize) {
                if (count($currentDoc) > 0) {
                    $doc = implode($separator, $currentDoc);
                    $docs[] = $doc;

                    // Handle overlap
                    while ($totalLength > $this->chunkOverlap || ($totalLength + $segmentLength + (count($currentDoc) > 0 ? strlen($separator) : 0) > $this->chunkSize && count($currentDoc) > 0)) {
                        $removed = array_shift($currentDoc);
                        $totalLength -= (strlen($removed) + (count($currentDoc) > 0 ? strlen($separator) : 0));
                    }
                }
            }

            $currentDoc[] = $segment;
            $totalLength += $segmentLength + (count($currentDoc) > 1 ? strlen($separator) : 0);
        }

        if (count($currentDoc) > 0) {
            $docs[] = implode($separator, $currentDoc);
        }

        return $docs;
    }
}
