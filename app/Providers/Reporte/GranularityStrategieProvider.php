<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Providers\Reporte;

use Illuminate\Support\ServiceProvider;
use App\Infrastructure\Reporte\Queries\Aggregators\Granularity\DailyReportGranularityStrategy;
use App\Infrastructure\Reporte\Queries\Aggregators\Granularity\MonthlyReportGranularityStrategy;
use App\Infrastructure\Reporte\Queries\Aggregators\Granularity\YearlyReportGranularityStrategy;
use App\Application\Reporte\Resolvers\Granularity\ReportGranularityResolver;

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
