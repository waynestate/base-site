<?php

namespace App\Traits;

use Carbon\Carbon;
use Throwable;

trait FiltersExpiredItems
{
    /**
     * Whether an item's explicit expiration has passed, considering the
     * earliest (or latest, when $useEarliest is false) of the given fields
     * that are actually set. An item with none of the fields set never expires.
     */
    public function isExpired(array $item, array $fields, bool $useEarliest = true): bool
    {
        $dates = collect($fields)
            ->map(fn ($field) => $this->parseExpiryDate($item[$field] ?? null))
            ->filter();

        if ($dates->isEmpty()) {
            return false;
        }

        $boundary = $useEarliest ? $dates->min() : $dates->max();

        return $boundary->isPast();
    }

    /**
     * Reject expired items from a list. See isExpired() for field semantics.
     */
    public function filterExpiredItems(array $items, array $fields, bool $useEarliest = true): array
    {
        return collect($items)
            ->reject(fn ($item) => $this->isExpired($item, $fields, $useEarliest))
            ->toArray();
    }

    /**
     * Parse a date field, treating empty strings, the '0000-00-00...' sentinel,
     * and unparseable values as "not set" (never expires on that field alone).
     * Date-only values (no time component) represent the whole day, so expiry
     * is evaluated against the end of that day rather than its start.
     */
    private function parseExpiryDate($value): ?Carbon
    {
        if (empty($value) || !is_string($value) || str_starts_with(trim($value), '0000-00-00')) {
            return null;
        }

        try {
            $date = Carbon::parse($value);
        } catch (Throwable $e) {
            return null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($value)) === 1) {
            return $date->endOfDay();
        }

        return $date;
    }
}
