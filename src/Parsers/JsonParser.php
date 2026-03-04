<?php

namespace LaraChain\Parsers;

/**
 * Class JsonParser
 *
 * Parses output into a JSON array, handling code blocks.
 */
class JsonParser extends OutputParser
{
    /**
     * Parse the JSON string output.
     *
     * @param string $text
     * @return array<string, mixed>
     * @throws \JsonException
     */
    public function parse(string $text): array
    {
        // Strip markdown code blocks if present
        $text = preg_replace('/```(?:json)?\n(.*?)\n```/s', '$1', $text);

        $decoded = json_decode(trim($text), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \JsonException("Failed to parse JSON: " . json_last_error_msg());
        }

        return $decoded;
    }
}
