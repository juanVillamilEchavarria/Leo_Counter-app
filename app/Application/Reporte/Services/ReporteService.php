<?php

namespace App\Application\Reporte\Services;

use App\Domains\Reporte\Resolvers\ReporteRepositoryResolver;
use App\Domains\Reporte\Enums\ReporteRepositoryType;
use App\Domains\Reporte\Enums\MovimientoReporteQueryType;
use App\Application\Reporte\Support\ReporteFinancialService;
use App\Application\Reporte\Support\ReporteFilterOptionsService;
use App\Domains\Reporte\Strategies\Resolvers\Granularity\ReportGranularityResolver;
use App\Domains\Reporte\Specifications\DefaultDateRangeSpecification;
use App\Domains\Reporte\Specifications\CategoriasIdsSpecification;
use App\Domains\Reporte\Specifications\CuentasIdsSpecification;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Domains\Reporte\ValueObjects\FullReportVO;
use App\Domains\Reporte\ValueObjects\IngresosVsGastosVO;
use App\Domains\Reporte\ValueObjects\PromedioVO;
use App\Domains\Reporte\ValueObjects\KPI\PeriodKPIVO;
use App\Domains\Reporte\ValueObjects\KPI\TotalsKPIVO;
use App\Domains\Reporte\ValueObjects\KPI\VariationsKPIVO;
use App\Domains\Reporte\ValueObjects\Category\FullDistributionCategoryVO;
use App\Domains\Reporte\ValueObjects\Form\ReporteFilterOptionsVO;
use App\Domains\Reporte\ValueObjects\ReporteQueryDTO;
use App\Domains\Reporte\Collections\KPICollection;
use App\Domains\Reporte\Collections\FinancialPeriodCollection;
use App\Domains\Reporte\Collections\DistributionCategoryCollection;
use App\Shared\DTOs\Querys\IdsDTO;

class ReporteService
{
    public function __construct(
        private ReporteFilterOptionsService $reporteFilterOptionsService,
        private ReporteRepositoryResolver $repositoryResolver,
        private ReporteFinancialService $reporteFinancialService,
        private ReportGranularityResolver $granularityResolver,
    ) {
    }

    public function getOptions()
    {
        return new ReporteFilterOptionsVO(
            categorias: $this->reporteFilterOptionsService->getValidCategories(),
            cuentas:    $this->reporteFilterOptionsService->getValidAccounts()
        );
    }

    public function getFullReport(array $data): FullReportVO
    {
        $dto = $this->buildReporteQueryDTO($data);
        $movimientoRepository = $this->repositoryResolver->resolve(ReporteRepositoryType::MOVIMIENTOS);
        $results = $movimientoRepository->getMultiple([
            MovimientoReporteQueryType::KPIS,
            MovimientoReporteQueryType::INGRESOS_VS_GASTOS,
            MovimientoReporteQueryType::CATEGORY_DISTRIBUTION,
            MovimientoReporteQueryType::BALANCE_NETO,
        ], $dto);

        /** @var KPICollection $kpiCollection */
        $kpiCollection = $results->get(MovimientoReporteQueryType::KPIS);
        /** @var FinancialPeriodCollection $financialPeriodCollection */
        $financialPeriodCollection = $results->get(MovimientoReporteQueryType::INGRESOS_VS_GASTOS);
        /** @var DistributionCategoryCollection $categoryCollection */
        $categoryCollection = $results->get(MovimientoReporteQueryType::CATEGORY_DISTRIBUTION);
        $balanceNeto = $results->get(MovimientoReporteQueryType::BALANCE_NETO);

        return new FullReportVO(
            KPIs: new PeriodKPIVO(
                totales: new TotalsKPIVO(
                    ingresos: $kpiCollection->totalIngresos(),
                    gastos: $kpiCollection->totalGastos(),
                    balance_neto: $kpiCollection->totalBalance(),
                    movimientos: $kpiCollection->totalMovimientos()
                ),
                variaciones: new VariationsKPIVO(
                    ingresos: null,
                    gastos: null,
                    balance_neto: null,
                    movimientos: null
                )
            ),
            ingresos_vs_gastos: new IngresosVsGastosVO(
                data: $financialPeriodCollection,
                promedios: new PromedioVO(
                    ingresos_por_periodo: $financialPeriodCollection->ingresosPeriodAverage(),
                    gastos_por_periodo: $financialPeriodCollection->gastosPeriodAverage(),
                    ingresos_por_movimiento: $financialPeriodCollection->ingresosIndividualAverage(),
                    gastos_por_movimiento: $financialPeriodCollection->gastosIndividualAverage()
                )
            ),
            distribucion_por_categoria: new FullDistributionCategoryVO(
                $categoryCollection,
                $categoryCollection->totalMovimientos()
            ),
            balance_neto: $balanceNeto,
            presupuesto: $this->reporteFinancialService->getUsedBudget($movimientoRepository,$dto)
        );
    }

    public function getPeriodKPIs(array $data): KPICollection
    {
        $dto = $this->buildReporteQueryDTO($data);
        $movimientoRepository = $this->repositoryResolver->resolve(ReporteRepositoryType::MOVIMIENTOS);

        return $movimientoRepository->get(MovimientoReporteQueryType::KPIS, $dto);
    }

    private function resolveDateRange(array $data): DateRange
    {
        return (new DefaultDateRangeSpecification())->isSatisfiedBy($data)
            ? DateRange::lastSixMonths()
            : DateRange::fromArray($data);
    }

    private function resolveCuentasIds(array $data): ?IdsDTO
    {
        return (new CuentasIdsSpecification())->isSatisfiedBy($data)
            ? IdsDTO::fromArray($data['cuentas'])
            : null;
    }

    private function resolveCategoriasIds(array $data): ?IdsDTO
    {
        return (new CategoriasIdsSpecification())->isSatisfiedBy($data)
            ? IdsDTO::fromArray($data['categorias'])
            : null;
    }

    private function buildReporteQueryDTO(array $data): ReporteQueryDTO
    {
        $dateRange = $this->resolveDateRange($data);
        $cuentas = $this->resolveCuentasIds($data);
        $categorias = $this->resolveCategoriasIds($data);
        $granularity = $this->granularityResolver->resolve($dateRange->diffDays());

        return new ReporteQueryDTO(
            dateRange: $dateRange,
            granularityStrategy: $granularity,
            only_categorias_fijas: $data['only_categorias_fijas'] ?? false,
            categorias: $categorias,
            cuentas: $cuentas
        );
    }
}
