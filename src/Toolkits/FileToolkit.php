<?php

namespace LaraChain\Toolkits;

use LaraChain\Contracts\ToolkitInterface;
use LaraChain\Tools\Tool;

/**
 * Class FileToolkit
 *
 * Provides tools for file operations.
 */
class FileToolkit implements ToolkitInterface
{
    /**
     * Get File management tools.
     *
     * @return array<int, string|\LaraChain\Contracts\ToolInterface>
     */
    public function getTools(): array
    {
        $readTool = new class extends Tool {
            protected string $name = 'read_file';
            protected string $description = 'Read file from path. Input should be `{"file_path": "path/string"}`.';

            public function run(array $input): mixed
            {
                $path = $input['file_path'] ?? null;
                if ($path && file_exists($path)) {
                    return file_get_contents($path);
                }
                return "File not found.";
            }
        };

        $writeTool = new class extends Tool {
            protected string $name = 'write_file';
            protected string $description = 'Write to a file. Input should be `{"file_path": "path", "contents": "string"}`.';

            public function run(array $input): mixed
            {
                $path = $input['file_path'] ?? null;
                $contents = $input['contents'] ?? '';
                if ($path) {
                    file_put_contents($path, $contents);
                    return "File written successfully.";
                }
                return "File path missing.";
            }
        };

        return [$readTool, $writeTool];
    }
}
