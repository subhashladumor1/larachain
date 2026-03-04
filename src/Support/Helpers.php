<?php

namespace LaraChain\Support;

/**
 * General helper utilities for LaraChain.
 */
class Helpers
{
    /**
     * Determines if given array is associative.
     *
     * @param array<mixed, mixed> $array
     * @return bool
     */
    public static function isAssoc(array $array): bool
    {
        if (empty($array)) {
            return false;
        }

        return array_keys($array) !== range(0, count($array) - 1);
    }
}

