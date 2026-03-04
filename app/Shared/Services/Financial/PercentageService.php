<?php

namespace App\Shared\Services\Financial;

class PercentageService{
        public function calculatePercentageChange( float $currentValue, float $previousValue){
            if($previousValue == 0) {
                return null;
            };
                  return round((($currentValue - $previousValue) / abs($previousValue)) * 100, 2);
    }
}