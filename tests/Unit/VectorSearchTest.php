<?php

use LaraChain\VectorStores\InMemoryVectorStore;
use LaraChain\Contracts\EmbeddingInterface;
use LaraChain\Retrieval\VectorRetriever;

test('in memory vector store and vector retriever', function () {
    // Mock EmbeddingInterface
    $embeddingMock = Mockery::mock(EmbeddingInterface::class);
    // Simple deterministic embedding
    $embeddingMock->shouldReceive('embedDocuments')->andReturn([
        [1.0, 0.0],
        [0.0, 1.0],
        [0.707, 0.707]
    ]);
    $embeddingMock->shouldReceive('embedQuery')->andReturn([1.0, 0.0]); // query looks for doc 1

    $store = new InMemoryVectorStore($embeddingMock);
    $store->addTexts(['Document A (X-axis)', 'Document B (Y-axis)', 'Document C (diagonal)']);

    $results = $store->similaritySearchVectorWithScore([1.0, 0.0], 2);

    expect($results)->toHaveCount(2)
        ->and($results[0]['document']['text'])->toBe('Document A (X-axis)');
    // Dot product with [1,0] should have Document A highest

    // Test Retriever
    $retriever = new VectorRetriever($store, 1);
    $docs = $retriever->getRelevantDocuments('Find X-axis');

    expect($docs)->toHaveCount(1)
        ->and($docs[0]['text'])->toBe('Document A (X-axis)');
});
