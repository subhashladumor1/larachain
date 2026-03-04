<?php

namespace LaraChain\VectorStores;

use LaraChain\Contracts\VectorStoreInterface;
use LaraChain\Contracts\EmbeddingInterface;

/**
 * Class InMemoryVectorStore
 *
 * A simple in-memory vector store that stores embeddings and supports cosine similarity search.
 */
class InMemoryVectorStore implements VectorStoreInterface
{
    /** @var array<int, array{text: string, embedding: array<int, float>, metadata: array<string, mixed>}> */
    protected array $documents = [];

    protected EmbeddingInterface $embeddingModel;

    /**
     * Constructor.
     *
     * @param EmbeddingInterface $embeddingModel
     */
    public function __construct(EmbeddingInterface $embeddingModel)
    {
        $this->embeddingModel = $embeddingModel;
    }

    /**
     * Add texts to the vector store.
     *
     * @param array<int, string> $texts
     * @param array<int, array<int, float>>|null $embeddings If null, will be generated using the embedding model
     * @param array<int, array<string, mixed>> $metadatas
     * @return void
     */
    public function addTexts(array $texts, ?array $embeddings = null, array $metadatas = []): void
    {
        if ($embeddings === null) {
            $embeddings = $this->embeddingModel->embedDocuments($texts);
        }

        foreach ($texts as $index => $text) {
            $this->documents[] = [
                'text' => $text,
                'embedding' => $embeddings[$index],
                'metadata' => $metadatas[$index] ?? [],
            ];
        }
    }

    /**
     * Perform a similarity search using cosine similarity.
     *
     * @param array<int, float> $queryEmbedding
     * @param int $k
     * @return array<int, array{document: array{text: string, embedding: array<int, float>, metadata: array<string, mixed>}, score: float}>
     */
    public function similaritySearchVectorWithScore(array $queryEmbedding, int $k = 4): array
    {
        $results = [];

        foreach ($this->documents as $doc) {
            $score = $this->cosineSimilarity($queryEmbedding, $doc['embedding']);
            $results[] = [
                'document' => $doc,
                'score' => $score,
            ];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($results, 0, $k);
    }

    /**
     * Perform a similarity search with a string query.
     *
     * @param string $query
     * @param int $k
     * @return array<int, mixed>
     */
    public function similaritySearch(string $query, int $k = 4): array
    {
        $embedding = $this->embeddingModel->embedQuery($query);
        $scoredResults = $this->similaritySearchVectorWithScore($embedding, $k);

        return array_column($scoredResults, 'document');
    }

    /**
     * Calculate Cosine Similarity between two vectors.
     *
     * @param array<int, float> $v1
     * @param array<int, float> $v2
     * @return float
     */
    protected function cosineSimilarity(array $v1, array $v2): float
    {
        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        foreach ($v1 as $i => $val) {
            $dotProduct += $val * ($v2[$i] ?? 0.0);
            $normA += $val * $val;
            $normB += ($v2[$i] ?? 0.0) * ($v2[$i] ?? 0.0);
        }

        if ($normA == 0.0 || $normB == 0.0) {
            return 0.0;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }
}
