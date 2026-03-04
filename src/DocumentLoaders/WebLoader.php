<?php

namespace LaraChain\DocumentLoaders;

use LaraChain\Contracts\DocumentLoaderInterface;

/**
 * Class WebLoader
 *
 * Loads parsing content from a simple webpage.
 */
class WebLoader implements DocumentLoaderInterface
{
    protected string $url;

    /**
     * WebLoader constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Load Webpage content and return documents.
     *
     * @return array<int, array{content: string, metadata: array<string, mixed>}>
     */
    public function load(): array
    {
        // For simplicity we use file_get_contents. In production, consider Guzzle.
        $html = @file_get_contents($this->url);

        if ($html === false) {
            throw new \Exception("Could not fetch URL: {$this->url}");
        }

        // Extremely basic strip tags
        $content = strip_tags($html);
        $content = preg_replace("/\s+/", " ", $content);

        return [
            [
                'content' => trim($content),
                'metadata' => ['source' => $this->url]
            ]
        ];
    }
}
