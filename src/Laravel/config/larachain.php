<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Drivers
    |--------------------------------------------------------------------------
    |
    | These settings define the default drivers used by LaraChain when no
    | specific driver is requested at runtime.
    |
    */
    'default' => [
        'llm' => env('LARACHAIN_LLM_DRIVER', 'openai'),
        'vectorstore' => env('LARACHAIN_VECTOR_DRIVER', 'memory'),
        'embeddings' => env('LARACHAIN_EMBEDDING_DRIVER', 'openai'),
    ],

    /*
    |--------------------------------------------------------------------------
    | LLM Providers (Models)
    |--------------------------------------------------------------------------
    |
    | LaraChain leverages the Laravel AI SDK for model management. You can
    | define your model aliases here.
    |
    */
    'llms' => [
        'openai' => [
            'model' => env('LARACHAIN_MODEL', 'gpt-4o'),
            'options' => [],
        ],
        'anthropic' => [
            'model' => 'claude-3-5-sonnet',
            'options' => [],
        ],
        'gemini' => [
            'model' => 'gemini-1.5-pro',
            'options' => [],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Vector Store Providers
    |--------------------------------------------------------------------------
    |
    | Define the connection settings for different vector databases.
    |
    */
    'vectorstores' => [
        'memory' => [
            'driver' => \LaraChain\VectorStores\InMemoryVectorStore::class,
        ],
        'postgres' => [
            'driver' => \LaraChain\VectorStores\PostgresVectorStore::class,
            'table' => 'embeddings',
            'vector_column' => 'embedding',
        ],
        'pinecone' => [
            'driver' => 'pinecone', // Future implementation
            'api_key' => env('PINECONE_API_KEY'),
            'index' => env('PINECONE_INDEX'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Embedding Providers
    |--------------------------------------------------------------------------
    */
    'embeddings' => [
        'openai' => [
            'model' => env('LARACHAIN_EMBEDDING_MODEL', 'text-embedding-3-small'),
        ],
        'voyage' => [
            'model' => 'voyage-2',
        ],
    ],
];
