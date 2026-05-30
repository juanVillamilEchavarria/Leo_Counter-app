<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::command('leo:process-daily-financial-tasks')
    ->timezone('America/Bogota')
    ->dailyAt('00:00');
