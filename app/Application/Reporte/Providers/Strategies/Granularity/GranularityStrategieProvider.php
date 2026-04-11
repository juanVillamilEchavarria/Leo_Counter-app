<?php

namespace App\Application\Reporte\Providers\Strategies\Granularity;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Strategies\Domain\Granularity\DailyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\Granularity\MonthlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\Granularity\YearlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;
class GranularityStrategieProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReportGranularityResolver::class, function () {
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
