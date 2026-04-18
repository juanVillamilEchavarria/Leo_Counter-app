<?php

namespace Tests\Unit\Application\Reporte\Handlers;

use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Application\Reporte\Queries\GenerateFinancialReportQuery;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\Enums\Statistic\PresupuestoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use Mockery;
use Tests\TestCase;

class GenerateReportHandlerTest extends TestCase
{
  private ReportQueryMapper $mapper;
    private iterable $contributors;
    private GenerateReportHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        // Obtener la instancia del contenedor, que ya resuelve sus dependencias
        $this->mapper = app(ReportQueryMapper::class);
        $this->contributors = [];
        $this->handler = new GenerateReportHandler($this->mapper, $this->contributors);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
    public function test_full_report_calls_all_contributors(): void
    {
        $dto = new GenerateFinancialReportQuery();

        $contributor1 = Mockery::mock(ReportContributorContract::class);
        $contributor2 = Mockery::mock(ReportContributorContract::class);

        $result1 = new ReporteQueryResult();
        $result2 = new ReporteQueryResult();

        $contributor1->shouldReceive('contribute')->once()->andReturn($result1);
        $contributor2->shouldReceive('contribute')->once()->andReturn($result2);

        $this->contributors = [$contributor1, $contributor2];
        $this->handler = new GenerateReportHandler($this->mapper, $this->contributors);

        $finalResult = $this->handler->fullReport($dto);

        $this->assertInstanceOf(ReporteQueryResult::class, $finalResult);
    }

    public function test_handle_with_specific_types_filters_contributors(): void
    {
        $dto = new GenerateFinancialReportQuery();

        $movimientoContributor = Mockery::mock(ReportContributorContract::class);
        $movimientoContributor->shouldReceive('shouldContribute')
            ->once()
            ->with([MovimientoReportStatisticType::KPIS])
            ->andReturn(true);
        $movimientoContributor->shouldReceive('handle')->once()->andReturn(new ReporteQueryResult());

        $presupuestoContributor = Mockery::mock(ReportContributorContract::class);
        $presupuestoContributor->shouldReceive('shouldContribute')
            ->once()
            ->with([MovimientoReportStatisticType::KPIS])
            ->andReturn(false);
        $presupuestoContributor->shouldReceive('handle')->never();

        $this->contributors = [$movimientoContributor, $presupuestoContributor];
        $this->handler = new GenerateReportHandler($this->mapper, $this->contributors);

        $result = $this->handler->handle([MovimientoReportStatisticType::KPIS], $dto);

        $this->assertInstanceOf(ReporteQueryResult::class, $result);
    }

    public function test_handle_merges_multiple_contributor_results(): void
    {
        $dto = new GenerateFinancialReportQuery();

        $contributor1 = Mockery::mock(ReportContributorContract::class);
        $contributor2 = Mockery::mock(ReportContributorContract::class);

        $types = [MovimientoReportStatisticType::KPIS, PresupuestoReportStatisticType::USED_BUDGET];

        $contributor1->shouldReceive('shouldContribute')->once()->with($types)->andReturn(true);
        $contributor2->shouldReceive('shouldContribute')->once()->with($types)->andReturn(true);

        $result1 = (new ReporteQueryResult())->add(MovimientoReportStatisticType::KPIS, ['kpi']);
        $result2 = (new ReporteQueryResult())->add(PresupuestoReportStatisticType::USED_BUDGET, ['budget']);

        $contributor1->shouldReceive('handle')->once()->andReturn($result1);
        $contributor2->shouldReceive('handle')->once()->andReturn($result2);

        $this->contributors = [$contributor1, $contributor2];
        $this->handler = new GenerateReportHandler($this->mapper, $this->contributors);

        $mergedResult = $this->handler->handle($types, $dto);

        $this->assertTrue($mergedResult->has(MovimientoReportStatisticType::KPIS));
        $this->assertTrue($mergedResult->has(PresupuestoReportStatisticType::USED_BUDGET));
    }

    public function test_maps_dto_to_query_object(): void
    {
        $dto = new GenerateFinancialReportQuery();
        $this->handler = new GenerateReportHandler($this->mapper, []);
        $result = $this->handler->fullReport($dto);
        $this->assertInstanceOf(ReporteQueryResult::class, $result);
    }
}