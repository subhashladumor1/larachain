<?php

namespace LaraChain\DocumentLoaders;

use LaraChain\Contracts\DocumentLoaderInterface;

/**
 * Class PDFLoader
 *
 * Loads text from a PDF file.
 */
class PDFLoader implements DocumentLoaderInterface
{
    protected string $filePath;

    /**
     * PDFLoader constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Load PDF content and return documents.
     * Note: This requires a third-party package like spatie/pdf-to-text to work fully.
     *
     * @return array<int, array{content: string, metadata: array<string, mixed>}>
     */
    public function load(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception("File not found: {$this->filePath}");
        }

        // Implementation omitted, requires specific package like `spatie/pdf-to-text`.
        // Returning placeholder for now.
        return [
            [
                'content' => "[PDF TEXT CONTENT EXTRACTED]",
                'metadata' => ['source' => $this->filePath]
            ]
        ];
    }
}
