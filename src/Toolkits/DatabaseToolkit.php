<?php

namespace LaraChain\Toolkits;

use LaraChain\Contracts\ToolkitInterface;
use LaraChain\Tools\Tool;

/**
 * Class DatabaseToolkit
 *
 * Provides tools for interacting with a database.
 */
class DatabaseToolkit implements ToolkitInterface
{
    /**
     * Get the tools related to the Database Toolkit.
     * For example purposes, we provide pseudo-tools as classes or anonymous tools.
     *
     * @return array<int, string|\LaraChain\Contracts\ToolInterface>
     */
    public function getTools(): array
    {
        // Example dynamic tools representing queries and schema checks
        $queryTool = new class extends Tool {
            protected string $name = 'query_sql_db';
            protected string $description = 'Input to this tool is a detailed and correct SQL query, output is a result from the database. If the query is not correct, an error message will be returned. If an error is returned, rewrite the query, check the query, and try again.';

            public function run(array $input): mixed
            {
                // In a real scenario, use Illuminate\Support\Facades\DB
                return "Mock Database Result for: " . json_encode($input);
            }
        };

        $schemaTool = new class extends Tool {
            protected string $name = 'schema_sql_db';
            protected string $description = 'Input to this tool is a comma-separated list of tables, output is the schema and sample rows for those tables.';

            public function run(array $input): mixed
            {
                return "Mock Database Schema for tables: " . json_encode($input);
            }
        };

        return [$queryTool, $schemaTool];
    }
}
