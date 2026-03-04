<?php

return [
    /**
     * Default model for generating text.
     */
    'default_model' => env('LARACHAIN_MODEL', 'gpt-4o'),

    /**
     * Default model for embeddings.
     */
    'default_embedding_model' => env('LARACHAIN_EMBEDDING_MODEL', 'text-embedding-3-small'),
];
