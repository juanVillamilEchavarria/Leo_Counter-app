<?php

namespace App\Domains\Reporte\ValueObjects;
use Illuminate\Support\Carbon;

final class DateRange {
    public function __construct(
        public readonly Carbon  $startDate ,
        public readonly Carbon  $endDate ,
    )
    {
    }

    public function diffDays(){
        return (int) $this->startDate->diffInDays($this->endDate);
    }

    public static function lastSixMonths(){
        return new self(Carbon::now()->subMonths(6), Carbon::now());
    }

    public static function fromArray(array $data){
        return new self(Carbon::parse($data['startDate']), Carbon::parse($data['endDate']));
    }
    public function toArray() : array{
        return [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ];
    }
}