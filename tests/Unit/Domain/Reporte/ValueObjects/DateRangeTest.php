<?php

namespace Tests\Unit\Domain\Reporte\ValueObjects;

use App\Domains\Reporte\ValueObjects\DateRange;
use DateTimeImmutable;
use Tests\TestCase;

class DateRangeTest extends TestCase
{
    public function test_can_create_date_range(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');
        $endDate = new DateTimeImmutable('2024-01-31');

        $dateRange = new DateRange($startDate, $endDate);

        $this->assertSame($startDate, $dateRange->startDate);
        $this->assertSame($endDate, $dateRange->endDate);
    }

    public function test_diff_days_calculates_correctly(): void
    {
        $start = new DateTimeImmutable('2025-01-01');
        $end = new DateTimeImmutable('2025-01-10');
        $range = new DateRange($start, $end);

        $this->assertEquals(9, $range->diffDays());
    }

    public function test_diff_days_with_same_date(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');

        $dateRange = new DateRange($startDate, $startDate);

        $this->assertEquals(0, $dateRange->diffDays());
    }

   public function test_get_previous_period_returns_correct_dates(): void
{
    $start = new DateTimeImmutable('2025-02-01');
    $end = new DateTimeImmutable('2025-02-10');
    $range = new DateRange($start, $end);

    $previous = $range->getPreviousPeriod();

    $this->assertEquals('2025-01-22', $previous->startDate->format('Y-m-d'));
    $this->assertEquals('2025-01-31', $previous->endDate->format('Y-m-d'));
}

   public function test_to_previous_period_returns_shifted_range(): void
    {
        $start = new DateTimeImmutable('2025-02-01');
        $end = new DateTimeImmutable('2025-02-10');
        $range = new DateRange($start, $end);

        $previous = $range->toPreviousPeriod();
        $this->assertEquals('2025-01-22', $previous->startDate->format('Y-m-d'));
        $this->assertEquals('2025-01-31', $previous->endDate->format('Y-m-d'));
    }

   public function test_previous_period_has_same_duration(): void
{
    // Usamos fechas en mitad de año para evitar variaciones por meses irregulares
    $startDate = new DateTimeImmutable('2024-05-10');
    $endDate   = new DateTimeImmutable('2024-05-20');

    $dateRange = new DateRange($startDate, $endDate);
    $previousPeriod = $dateRange->getPreviousPeriod();

    $this->assertEquals(
        $dateRange->diffDays(),
        $previousPeriod->diffDays()
    );
}
    public function test_last_six_months_static_constructor(): void
    {
        $range = DateRange::lastSixMonths();
        $now = new DateTimeImmutable();
        $sixMonthsAgo = $now->modify('-6 months');

        $this->assertEquals($sixMonthsAgo->format('Y-m-d'), $range->startDate->format('Y-m-d'));
        $this->assertEquals($now->format('Y-m-d'), $range->endDate->format('Y-m-d'));
    }

    public function test_last_month_static_constructor(): void
    {
        $range = DateRange::lastMonth();

        // Verify it's approximately 1 month
        $this->assertGreaterThan(20, $range->diffDays());
        $this->assertLessThan(35, $range->diffDays());
    }

    public function test_date_range_is_immutable(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');
        $endDate = new DateTimeImmutable('2024-01-31');

        $dateRange = new DateRange($startDate, $endDate);
        $previousPeriod = $dateRange->getPreviousPeriod();

        // Original should not be modified
        $this->assertEquals('2024-01-01', $dateRange->startDate->format('Y-m-d'));
        $this->assertNotEquals(
            $dateRange->startDate->format('Y-m-d'),
            $previousPeriod->startDate->format('Y-m-d')
        );
    }
}