<?php

namespace LaraChain\VectorStores;

use LaraChain\Contracts\VectorStoreInterface;
use LaraChain\Contracts\EmbeddingInterface;
use Illuminate\Support\Facades\DB;

/**
 * Class PostgresVectorStore
 *
 * Vector store implementation using PostgreSQL with pgvector extension.
 */
class PostgresVectorStore implements VectorStoreInterface
{
    protected EmbeddingInterface $embeddingModel;
    protected string $table;
    protected string $vectorColumn;
    protected string $contentColumn;
    protected string $metadataColumn;

    /**
     * PostgresVectorStore constructor.
     *
     * @param EmbeddingInterface $embeddingModel
     * @param string $table
     * @param string $vectorColumn
     * @param string $contentColumn
     * @param string $metadataColumn
     */
    public function __construct(
        EmbeddingInterface $embeddingModel,
        string $table = 'embeddings',
        string $vectorColumn = 'embedding',
        string $contentColumn = 'content',
        string $metadataColumn = 'metadata'
    ) {
        $this->embeddingModel = $embeddingModel;
        $this->table = $table;
        $this->vectorColumn = $vectorColumn;
        $this->contentColumn = $contentColumn;
        $this->metadataColumn = $metadataColumn;
    }

    /**
     * Add texts to the database.
     *
     * @param array<int, string> $texts
     * @param array<int, array<int, float>>|null $embeddings
     * @param array<int, array<string, mixed>> $metadatas
     * @return void
     */
    public function addTexts(array $texts, ?array $embeddings = null, array $metadatas = []): void
    {
        if ($embeddings === null) {
            $embeddings = $this->embeddingModel->embedDocuments($texts);
        }

        foreach ($texts as $index => $text) {
            $embedding = $embeddings[$index];
            $metadata = $metadatas[$index] ?? [];

            // Convert array to pgvector string format: [1.2, 3.4, ...]
            $vectorString = '[' . implode(',', $embedding) . ']';

            DB::table($this->table)->insert([
                $this->contentColumn => $text,
                $this->vectorColumn => DB::raw("'$vectorString'::vector"),
                $this->metadataColumn => json_encode($metadata),
            ]);
        }
    }

    /**
     * Perform a similarity search.
     *
     * @param array<int, float> $queryEmbedding
     * @param int $k
     * @return array<int, array{document: array{text: string, metadata: array<string, mixed>}, score: float}>
     */
    public function similaritySearchVectorWithScore(array $queryEmbedding, int $k = 4): array
    {
        $vectorString = '[' . implode(',', $queryEmbedding) . ']';

        // Using Cosine Distance (<=> operator in pgvector)
        // Cosine Similarity = 1 - Cosine Distance
        $results = DB::table($this->table)
            ->select($this->contentColumn, $this->metadataColumn)
            ->selectRaw("1 - ($this->vectorColumn <=> '$vectorString'::vector) as score")
            ->orderByRaw("$this->vectorColumn <=> '$vectorString'::vector")
            ->limit($k)
            ->get();

        return $results->map(function ($row) {
            return [
                'document' => [
                    'text' => $row->{$this->contentColumn},
                    'metadata' => json_decode($row->{$this->metadataColumn}, true) ?? [],
                ],
                'score' => (float) $row->score,
            ];
        })->toArray();
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
}
