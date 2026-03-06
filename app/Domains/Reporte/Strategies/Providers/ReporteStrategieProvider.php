<?php

namespace App\Domains\Reporte\Strategies\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Strategies\Domain\DailyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\MonthlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\YearlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Resolvers\ReportGranularityResolver;
class ReporteStrategieProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReportGranularityResolver::class, function ($app) {
            return new ReportGranularityResolver([
                new DailyReportGranularityStrategy(),
                new MonthlyReportGranularityStrategy(),
                new YearlyReportGranularityStrategy(),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
