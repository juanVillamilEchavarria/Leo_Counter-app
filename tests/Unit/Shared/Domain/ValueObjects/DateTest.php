<?php
namespace Tests\Unit\Shared\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

final class DateTest extends TestCase
{

    public function test_it_add_months(){
        $date = new Date(new DateTimeImmutable('2022-01-01'));
        $newDate = $date->addMonths('2');
        $this->assertEquals('2022-03-01', $newDate->format('Y-m-d'));
    }

    public function test_it_add_days(){
        $date = new Date(new DateTimeImmutable('2022-01-01'));
        $newDate = $date->addDays('2');
        $this->assertEquals('2022-01-03', $newDate->format('Y-m-d'));
    }
    public function test_it_add_weeks(){
        $date = new Date(new DateTimeImmutable('2022-01-01'));
        $newDate = $date->addWeeks('2');
        $this->assertEquals('2022-01-15', $newDate->format('Y-m-d'));
    }

    public function test_it_add_years(){
        $date = new Date(new DateTimeImmutable('2022-01-01'));
        $newDate = $date->addYears('2');
        $this->assertEquals('2024-01-01', $newDate->format('Y-m-d'));
    }

    public function test_it_returns_format_correctly(){
        $date = new Date(new DateTimeImmutable('2022-01-01'));
        $this->assertEquals('2022-01-01', $date->format('Y-m-d'));
    }

}