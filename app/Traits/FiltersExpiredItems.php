<?php

namespace App\Traits;

trait FiltersExpiredItems
{
    /**
     * Whether an item's explicit expiration has passed, considering the
     * earliest (or latest, when $useEarliest is false) of the given fields
     * that are actually set. An item with none of the fields set never expires.
     */
    public function isExpired(array $item, array $fields, bool $useEarliest = true): bool
    {
        $timestamps = [];

        foreach ($fields as $field) {
            if (!empty($item[$field])) {
                $ts = $this->parseExpiryTimestamp($item[$field]);
                if ($ts !== null) {
                    $timestamps[] = $ts;
                }
            }
        }

        if (empty($timestamps)) {
            return false;
        }

        $boundary = $useEarliest ? min($timestamps) : max($timestamps);

        return $boundary < time();
    }

    /**
     * Reject expired items from a list. See isExpired() for field semantics.
     */
    public function filterExpiredItems(array $items, array $fields, bool $useEarliest = true): array
    {
        $filtered = [];

        foreach ($items as $key => $item) {
            if (is_array($item) && !$this->isExpired($item, $fields, $useEarliest)) {
                $filtered[$key] = $item;
            }
        }

        return $filtered;
    }

    /**
     * Parse a date field to a Unix timestamp integer, treating empty strings,
     * the '0000-00-00...' sentinel, and unparseable values as null ("not set").
     * Date-only values (no time component) represent the whole day, so expiry
     * is evaluated against the end of that day (23:59:59) rather than its start.
     */
    public function parseExpiryTimestamp(mixed $value): ?int
    {
        if (empty($value) || !is_string($value)) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '' || str_starts_with($trimmed, '0000-00-00')) {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $trimmed) === 1) {
            $ts = strtotime($trimmed.' 23:59:59');

            return $ts !== false ? $ts : null;
        }

        $ts = strtotime($trimmed);

        return $ts !== false ? $ts : null;
    }
}
