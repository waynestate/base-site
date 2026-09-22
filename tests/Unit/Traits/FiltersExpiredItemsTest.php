<?php

namespace Tests\Unit\Traits;

use App\Traits\FiltersExpiredItems;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class FiltersExpiredItemsTest extends TestCase
{
    private function subject(): object
    {
        return new class () {
            use FiltersExpiredItems;
        };
    }

    #[Test]
    public function item_with_no_expiry_fields_set_is_never_expired(): void
    {
        $item = ['title' => 'Evergreen', 'end_date' => '', 'display_end_date' => '0000-00-00 00:00:00'];

        $this->assertFalse($this->subject()->isExpired($item, ['end_date', 'display_end_date']));
    }

    #[Test]
    public function single_field_in_the_past_is_expired(): void
    {
        $item = ['date' => now()->subDays(3)->format('Y-m-d')];

        $this->assertTrue($this->subject()->isExpired($item, ['date']));
    }

    #[Test]
    public function single_field_today_is_not_expired(): void
    {
        // Date-only fields are evaluated against the END of that day, so an
        // event happening later today isn't hidden as already past.
        $item = ['date' => now()->format('Y-m-d')];

        $this->assertFalse($this->subject()->isExpired($item, ['date']));
    }

    #[Test]
    public function single_field_in_the_future_is_not_expired(): void
    {
        $item = ['date' => now()->addDays(3)->format('Y-m-d')];

        $this->assertFalse($this->subject()->isExpired($item, ['date']));
    }

    #[Test]
    public function earliest_mode_expires_when_the_earlier_field_has_passed(): void
    {
        $item = [
            'end_date' => now()->subDays(1)->format('Y-m-d H:i:s'),
            'display_end_date' => now()->addDays(10)->format('Y-m-d H:i:s'),
        ];

        $this->assertTrue($this->subject()->isExpired($item, ['end_date', 'display_end_date'], true));
    }

    #[Test]
    public function latest_mode_does_not_expire_until_the_later_field_has_passed(): void
    {
        $item = [
            'end_date' => now()->subDays(1)->format('Y-m-d'),
            'repeat_end_date' => now()->addDays(10)->format('Y-m-d'),
        ];

        $this->assertFalse($this->subject()->isExpired($item, ['end_date', 'repeat_end_date'], false));
    }

    #[Test]
    public function latest_mode_expires_once_both_fields_have_passed(): void
    {
        $item = [
            'end_date' => now()->subDays(10)->format('Y-m-d'),
            'repeat_end_date' => now()->subDays(1)->format('Y-m-d'),
        ];

        $this->assertTrue($this->subject()->isExpired($item, ['end_date', 'repeat_end_date'], false));
    }

    #[Test]
    public function sentinel_values_are_treated_as_not_set(): void
    {
        $item = [
            'end_date' => '',
            'display_end_date' => '0000-00-00 00:00:00',
        ];

        $this->assertFalse($this->subject()->isExpired($item, ['end_date', 'display_end_date']));
    }

    #[Test]
    public function unparseable_value_is_treated_as_not_set(): void
    {
        $item = ['end_date' => 'not-a-real-date'];

        $this->assertFalse($this->subject()->isExpired($item, ['end_date']));
    }

    #[Test]
    public function filter_expired_items_rejects_only_expired_entries(): void
    {
        $items = [
            ['title' => 'Expired', 'end_date' => now()->subDays(1)->format('Y-m-d H:i:s'), 'display_end_date' => ''],
            ['title' => 'Active', 'end_date' => now()->addDays(1)->format('Y-m-d H:i:s'), 'display_end_date' => ''],
            ['title' => 'Evergreen', 'end_date' => '', 'display_end_date' => '0000-00-00 00:00:00'],
        ];

        $filtered = $this->subject()->filterExpiredItems($items, ['end_date', 'display_end_date']);

        $this->assertCount(2, $filtered);
        $this->assertEquals(['Active', 'Evergreen'], collect($filtered)->pluck('title')->values()->toArray());
    }

    #[Test]
    public function filter_expired_items_skips_non_array_entries(): void
    {
        $items = [
            'invalid_item',
            null,
            123,
            ['title' => 'Active', 'end_date' => now()->addDays(1)->format('Y-m-d H:i:s')],
        ];

        $filtered = $this->subject()->filterExpiredItems($items, ['end_date']);

        $this->assertCount(1, $filtered);
        $this->assertEquals(['Active'], collect($filtered)->pluck('title')->values()->toArray());
    }

    #[Test]
    public function parse_expiry_timestamp_returns_null_for_empty_or_non_string_values(): void
    {
        $this->assertNull($this->subject()->parseExpiryTimestamp(null));
        $this->assertNull($this->subject()->parseExpiryTimestamp(''));
        $this->assertNull($this->subject()->parseExpiryTimestamp(0));
        $this->assertNull($this->subject()->parseExpiryTimestamp(12345));
        $this->assertNull($this->subject()->parseExpiryTimestamp(['2026-01-01']));
        $this->assertNull($this->subject()->parseExpiryTimestamp(false));
        $this->assertNull($this->subject()->parseExpiryTimestamp(true));
    }

    #[Test]
    public function parse_expiry_timestamp_parses_date_only_and_datetime_strings(): void
    {
        $dateOnly = '2026-09-01';
        $expectedDateOnly = strtotime('2026-09-01 23:59:59');
        $this->assertSame($expectedDateOnly, $this->subject()->parseExpiryTimestamp($dateOnly));

        $dateTime = '2026-09-01 12:00:00';
        $expectedDateTime = strtotime($dateTime);
        $this->assertSame($expectedDateTime, $this->subject()->parseExpiryTimestamp($dateTime));
    }
}
