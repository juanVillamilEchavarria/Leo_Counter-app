<?php

namespace App\Shared\Services\Financial;

class PercentageService{
        public function calculatePercentageChange( float $currentValue, float $previousValue){
            if($previousValue == 0) {
                return null;
            };
                  return round((($currentValue - $previousValue) / abs($previousValue)) * 100, 2);
    }

    public function calculatePercentage(float $value, float $divider): float {
        if($divider == 0) {
            return 0;
        }
        return round(($value / $divider) * 100, 2);
    }
}