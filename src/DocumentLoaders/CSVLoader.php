<?php

namespace LaraChain\DocumentLoaders;

use LaraChain\Contracts\DocumentLoaderInterface;

/**
 * Class CSVLoader
 *
 * Loads and parses a CSV file into documents.
 */
class CSVLoader implements DocumentLoaderInterface
{
    protected string $filePath;

    /**
     * CSVLoader constructor.
     *
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Load CSV and return structured documents.
     *
     * @return array<int, array{content: string, metadata: array<string, mixed>}>
     */
    public function load(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception("File not found: {$this->filePath}");
        }

        $documents = [];
        if (($handle = fopen($this->filePath, "r")) !== false) {
            $headers = fgetcsv($handle);
            $rowIndex = 1;

            if ($headers) {
                while (($data = fgetcsv($handle)) !== false) {
                    $row = array_combine($headers, $data);
                    // Create a simple string representation
                    $contentItems = [];
                    foreach ($row as $key => $value) {
                        $contentItems[] = "{$key}: {$value}";
                    }

                    $documents[] = [
                        'content' => implode("\n", $contentItems),
                        'metadata' => ['source' => $this->filePath, 'row' => $rowIndex]
                    ];
                    $rowIndex++;
                }
            }
            fclose($handle);
        }

        return $documents;
    }
}
