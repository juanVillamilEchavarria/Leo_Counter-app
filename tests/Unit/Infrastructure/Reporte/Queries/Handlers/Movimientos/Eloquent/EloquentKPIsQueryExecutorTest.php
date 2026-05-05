<?php

namespace Tests\Unit\Infrastructure\Reporte\Queries\QueryExecutors\Movimientos\Eloquent;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Infrastructure\Reporte\Queries\Executors\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver;
use App\Models\Categoria\Categoria;
use App\Models\Cuenta\Cuenta;
use App\Models\Movimiento\Movimiento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;

class EloquentKPIsQueryExecutorTest extends TestCase
{
    use RefreshDatabase;

    private EloquentKPIsQueryExecutor $handler;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('tipo_movimientos')->insert([
            ['id' => TipoMovimientoEnum::INGRESO->value, 'tipo_movimiento' => 'Ingreso'],
            ['id' => TipoMovimientoEnum::GASTO->value, 'tipo_movimiento' => 'Gasto'],
        ]);
        $categorias = Categoria::factory()->count(2)->create();
        $categoria = $categorias->first();

        $cuenta = Cuenta::factory()->create();

        // Crear exactamente los movimientos necesarios para los tests
        Movimiento::factory()->create([
            'fecha'              => '2024-01-15',
            'tipo_movimiento_id' => TipoMovimientoEnum::INGRESO->value,
            'monto'              => 1000.00,
            'categoria_id'       => $categoria->id,
            'cuenta_id'          => $cuenta->id,
        ]);

        Movimiento::factory()->create([
            'fecha'              => '2024-01-15',
            'tipo_movimiento_id' => TipoMovimientoEnum::GASTO->value,
            'monto'              => 500.00,
            'categoria_id'       => $categoria->id,
            'cuenta_id'          => $cuenta->id,
        ]);

        $resolver = app(MovimientoQueryRelationResolver::class);

        $this->handler = new EloquentKPIsQueryExecutor($resolver);
    }

    public function test_supports_kpis_type(): void
    {
        $this->assertTrue($this->handler->supports(MovimientoReportStatisticType::KPIS));
        $this->assertFalse($this->handler->supports(MovimientoReportStatisticType::BALANCE_NETO));
    }

    public function test_handle_returns_kpi_collection(): void
    {
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-01-31')
        );

        $dto = new ReporteQuery(
            granularityStrategy: new \App\Infrastructure\Reporte\Queries\Aggregators\Granularity\MonthlyReportGranularityStrategy(),
            dateRange: $dateRange,
            only_categorias_fijas: false,
            categorias: null,
            cuentas: null
        );

        $result = $this->handler->handle($dto);

        $this->assertInstanceOf(\App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection::class, $result);
        $this->assertCount(1, $result);
    }

    public function test_handle_calculates_correct_totals(): void
    {
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-01-31')
        );

        $dto = new ReporteQuery(
            granularityStrategy: new \App\Infrastructure\Reporte\Queries\Aggregators\Granularity\MonthlyReportGranularityStrategy(),
            dateRange: $dateRange,
            only_categorias_fijas: false,
            categorias: null,
            cuentas: null
        );

        $result = $this->handler->handle($dto);
        $kpi = $result->first();

        $this->assertEquals(1000.00, $kpi->ingresos);
        $this->assertEquals(500.00, $kpi->gastos);
        $this->assertEquals(2, $kpi->total_movimientos);
    }

   public function test_handle_with_daily_granularity(): void
    {
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-01-14'),
            new DateTimeImmutable('2024-01-16')
        );

        $dto = new ReporteQuery(
            granularityStrategy: new \App\Infrastructure\Reporte\Queries\Aggregators\Granularity\DailyReportGranularityStrategy(),
            dateRange: $dateRange,
            only_categorias_fijas: false,
            categorias: null,
            cuentas: null
        );

        $result = $this->handler->handle($dto);

        $this->assertCount(1, $result);
        
        // Validar que los totales del único día son correctos
        $kpi = $result->first();
        $this->assertEquals(1000.00, $kpi->ingresos);
        $this->assertEquals(500.00, $kpi->gastos);
        $this->assertEquals(2, $kpi->total_movimientos);
    }

    public function test_handle_with_no_movements_returns_empty_collection(): void
    {
        Movimiento::query()->delete();

        $dateRange = new DateRange(
            new DateTimeImmutable('2024-02-01'),
            new DateTimeImmutable('2024-02-28')
        );

        $dto = new ReporteQuery(
            granularityStrategy: new \App\Infrastructure\Reporte\Queries\Aggregators\Granularity\MonthlyReportGranularityStrategy(),
            dateRange: $dateRange,
            only_categorias_fijas: false,
            categorias: null,
            cuentas: null
        );

        $result = $this->handler->handle($dto);

        $this->assertCount(0, $result);
    }
}