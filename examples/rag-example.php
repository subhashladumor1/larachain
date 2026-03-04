<?php

require __DIR__ . '/../vendor/autoload.php';

use LaraChain\DocumentLoaders\WebLoader;
use LaraChain\Embeddings\EmbeddingModel;
use LaraChain\VectorStores\InMemoryVectorStore;
use LaraChain\Retrieval\VectorRetriever;

echo "--- LaraChain RAG / Retrieval Example ---\n";

// 1. Load documents
$loader = new WebLoader('https://example.com');
$documents = $loader->load();

// 2. Initialize Vector Store with Embedding Model
$embeddingModel = new EmbeddingModel('text-embedding-3-small');
$vectorStore = new InMemoryVectorStore($embeddingModel);

// Extract text for vectors
$texts = array_column($documents, 'content');
$metadatas = array_column($documents, 'metadata');

echo "Generating Embeddings...\n";
// $vectorStore->addTexts($texts, null, $metadatas);

echo "Ready for Retrieval.\n";

$retriever = new VectorRetriever($vectorStore, 1);
// $results = $retriever->getRelevantDocuments("What is the domain about?");

// print_r($results);
