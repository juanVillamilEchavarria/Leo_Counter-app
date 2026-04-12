<?php

namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Domains\Reporte\Strategies\Domain\Granularity\DailyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\Granularity\MonthlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Domain\Granularity\YearlyReportGranularityStrategy;
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;

final class GranularityStrategieProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ReportGranularityResolver::class, static function (): ReportGranularityResolver {
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
