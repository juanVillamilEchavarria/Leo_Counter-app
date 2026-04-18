# Ejemplos de Tests Recomendados - Leo Counter App

Este documento complementa la investigación con ejemplos de tests para cada capa de la aplicación.

---

## 1. TESTS PARA DOMAIN LAYER

### 1.1 Tests para DateRange Value Object

```php
<?php

namespace Tests\Unit\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\ValueObjects\DateRange;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase
{
    public function test_can_create_date_range_with_valid_dates(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');
        $endDate = new DateTimeImmutable('2024-01-31');
        
        $dateRange = new DateRange($startDate, $endDate);
        
        $this->assertSame($startDate, $dateRange->startDate);
        $this->assertSame($endDate, $dateRange->endDate);
    }
    
    public function test_can_calculate_difference_in_days(): void
    {
        $startDate = new DateTimeImmutable('2024-01-01');
        $endDate = new DateTimeImmutable('2024-01-31');
        
        $dateRange = new DateRange($startDate, $endDate);
        
        $this->assertEquals(30, $dateRange->diffDays());
    }
    
    public function test_can_get_previous_period(): void
    {
        $startDate = new DateTimeImmutable('2024-02-01');
        $endDate = new DateTimeImmutable('2024-02-29');
        
        $dateRange = new DateRange($startDate, $endDate);
        $previousPeriod = $dateRange->getPreviousPeriod();
        
        $this->assertEquals(29, $previousPeriod->diffDays()); // 29 days in January
        $this->assertLessThan($dateRange->startDate, $previousPeriod->endDate);
    }
    
    public function test_last_six_months_static_method(): void
    {
        $dateRange = DateRange::lastSixMonths();
        
        $this->assertInstanceOf(DateRange::class, $dateRange);
        $this->assertGreaterThan(150, $dateRange->diffDays());
    }
    
    public function test_last_month_static_method(): void
    {
        $dateRange = DateRange::lastMonth();
        
        $this->assertInstanceOf(DateRange::class, $dateRange);
        $this->assertGreaterThanOrEqual(28, $dateRange->diffDays());
        $this->assertLessThanOrEqual(31, $dateRange->diffDays());
    }
    
    public function test_to_previous_period_is_alias(): void
    {
        $startDate = new DateTimeImmutable('2024-02-01');
        $endDate = new DateTimeImmutable('2024-02-29');
        
        $dateRange = new DateRange($startDate, $endDate);
        
        $this->assertEquals(
            $dateRange->getPreviousPeriod()->startDate,
            $dateRange->toPreviousPeriod()->startDate
        );
    }
}
```

---

### 1.2 Tests para ReporteQueryResult Value Object

```php
<?php

namespace Tests\Unit\Domains\Reporte\ValueObjects;

use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use PHPUnit\Framework\TestCase;

class ReporteQueryResultTest extends TestCase
{
    public function test_can_add_and_get_result(): void
    {
        $result = new ReporteQueryResult();
        $data = ['total' => 1000];
        
        $newResult = $result->add(MovimientoReportStatisticType::KPIS, $data);
        
        $this->assertEquals($data, $newResult->get(MovimientoReportStatisticType::KPIS));
    }
    
    public function test_has_method_returns_true_if_result_exists(): void
    {
        $result = new ReporteQueryResult();
        $result = $result->add(MovimientoReportStatisticType::KPIS, ['data' => true]);
        
        $this->assertTrue($result->has(MovimientoReportStatisticType::KPIS));
        $this->assertFalse($result->has(MovimientoReportStatisticType::BALANCE_NETO));
    }
    
    public function test_get_throws_exception_if_result_not_found(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $result = new ReporteQueryResult();
        $result->get(MovimientoReportStatisticType::KPIS);
    }
    
    public function test_can_add_and_get_previous_results(): void
    {
        $result = new ReporteQueryResult();
        $currentData = ['total' => 1000];
        $previousData = ['total' => 900];
        
        $result = $result->add(MovimientoReportStatisticType::KPIS, $currentData);
        $result = $result->addPrevious(MovimientoReportStatisticType::KPIS, $previousData);
        
        $this->assertEquals($previousData, $result->getPrevious(MovimientoReportStatisticType::KPIS));
    }
    
    public function test_get_previous_returns_null_if_not_set(): void
    {
        $result = new ReporteQueryResult();
        $result = $result->add(MovimientoReportStatisticType::KPIS, ['data']);
        
        $this->assertNull($result->getPrevious(MovimientoReportStatisticType::KPIS));
    }
    
    public function test_has_previous_returns_correct_boolean(): void
    {
        $result = new ReporteQueryResult();
        $result = $result->add(MovimientoReportStatisticType::KPIS, ['data']);
        $result = $result->addPrevious(MovimientoReportStatisticType::KPIS, ['prev']);
        
        $this->assertTrue($result->hasPrevious(MovimientoReportStatisticType::KPIS));
        $this->assertFalse($result->hasPrevious(MovimientoReportStatisticType::BALANCE_NETO));
    }
    
    public function test_is_immutable(): void
    {
        $result1 = new ReporteQueryResult();
        $result2 = $result1->add(MovimientoReportStatisticType::KPIS, ['data']);
        
        $this->assertNotSame($result1, $result2);
        $this->assertFalse($result1->has(MovimientoReportStatisticType::KPIS));
        $this->assertTrue($result2->has(MovimientoReportStatisticType::KPIS));
    }
}
```

---

### 1.3 Tests para MovimientoReportStatisticType Enum

```php
<?php

namespace Tests\Unit\Domains\Reporte\Enums\Statistic;

use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use PHPUnit\Framework\TestCase;

class MovimientoReportStatisticTypeTest extends TestCase
{
    public function test_enum_has_all_expected_cases(): void
    {
        $this->assertSame('kpis', MovimientoReportStatisticType::KPIS->value);
        $this->assertSame('balance_neto', MovimientoReportStatisticType::BALANCE_NETO->value);
        $this->assertSame('ingresos_vs_gastos', MovimientoReportStatisticType::INGRESOS_VS_GASTOS->value);
        $this->assertSame('category_distribution', MovimientoReportStatisticType::CATEGORY_DISTRIBUTION->value);
    }
    
    public function test_full_report_returns_all_types(): void
    {
        $types = MovimientoReportStatisticType::fullReport();
        
        $this->assertCount(6, $types);
        $this->assertContains(MovimientoReportStatisticType::KPIS, $types);
        $this->assertContains(MovimientoReportStatisticType::BALANCE_NETO, $types);
    }
    
    public function test_home_dashboard_returns_subset(): void
    {
        $types = MovimientoReportStatisticType::homeDashboard();
        
        $this->assertCount(2, $types);
        $this->assertContains(MovimientoReportStatisticType::KPIS, $types);
        $this->assertContains(MovimientoReportStatisticType::INGRESOS_VS_GASTOS, $types);
    }
    
    public function test_kpis_requires_comparative_data(): void
    {
        $this->assertTrue(MovimientoReportStatisticType::KPIS->requiresComparativeData());
        $this->assertFalse(MovimientoReportStatisticType::BALANCE_NETO->requiresComparativeData());
        $this->assertFalse(MovimientoReportStatisticType::INGRESOS_VS_GASTOS->requiresComparativeData());
    }
    
    public function test_with_comparative_data_returns_only_comparative_types(): void
    {
        $types = MovimientoReportStatisticType::withComparativeData();
        
        $this->assertNotEmpty($types);
        foreach ($types as $type) {
            $this->assertTrue($type->requiresComparativeData());
        }
    }
}
```

---

## 2. TESTS PARA APPLICATION LAYER

### 2.1 Tests para GenerateReportHandler

```php
<?php

namespace Tests\Feature\Application\Reporte\Handlers;

use App\Application\Reporte\DTOs\GenerateFinancialReportQuery;
use App\Application\Reporte\Handlers\GenerateReportHandler;
use App\Application\Reporte\Contracts\ReportContributorContract;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use Tests\TestCase;
use Mockery\MockInterface;

class GenerateReportHandlerTest extends TestCase
{
    private MockInterface $mapperMock;
    private MockInterface $contributorMock;
    private GenerateReportHandler $handler;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mapperMock = $this->mock('App\Application\Reporte\Mappers\ReportQueryMapper');
        $this->contributorMock = $this->mock(ReportContributorContract::class);
        
        $this->handler = new GenerateReportHandler(
            $this->mapperMock,
            [$this->contributorMock]
        );
    }
    
    public function test_handle_maps_dto_to_query(): void
    {
        $dto = new GenerateFinancialReportQuery();
        $query = $this->createMockReporteQuery();
        
        $this->mapperMock->shouldReceive('map')->with($dto)->andReturn($query);
        $this->contributorMock->shouldReceive('shouldContribute')->andReturn(false);
        
        $this->handler->handle([MovimientoReportStatisticType::KPIS], $dto);
        
        $this->mapperMock->shouldHaveReceived('map');
    }
    
    public function test_handle_filters_contributors_by_type(): void
    {
        $dto = new GenerateFinancialReportQuery();
        $query = $this->createMockReporteQuery();
        $types = [MovimientoReportStatisticType::KPIS];
        
        $this->mapperMock->shouldReceive('map')->andReturn($query);
        $this->contributorMock->shouldReceive('shouldContribute')
            ->with($types)
            ->andReturn(false);
        
        $this->handler->handle($types, $dto);
        
        $this->contributorMock->shouldHaveReceived('shouldContribute');
    }
    
    public function test_handle_calls_contributing_handlers(): void
    {
        $dto = new GenerateFinancialReportQuery();
        $query = $this->createMockReporteQuery();
        $types = [MovimientoReportStatisticType::KPIS];
        $result = new ReporteQueryResult();
        
        $this->mapperMock->shouldReceive('map')->andReturn($query);
        $this->contributorMock->shouldReceive('shouldContribute')
            ->with($types)
            ->andReturn(true);
        $this->contributorMock->shouldReceive('handle')
            ->with($query, $types)
            ->andReturn($result);
        
        $finalResult = $this->handler->handle($types, $dto);
        
        $this->assertInstanceOf(ReporteQueryResult::class, $finalResult);
        $this->contributorMock->shouldHaveReceived('handle');
    }
    
    public function test_full_report_calls_all_contributors(): void
    {
        $dto = new GenerateFinancialReportQuery();
        $query = $this->createMockReporteQuery();
        $result = new ReporteQueryResult();
        
        $this->mapperMock->shouldReceive('map')->andReturn($query);
        $this->contributorMock->shouldReceive('contribute')
            ->with($query)
            ->andReturn($result);
        
        $this->handler->fullReport($dto);
        
        $this->contributorMock->shouldHaveReceived('contribute');
    }
    
    private function createMockReporteQuery(): ReporteQuery
    {
        // Mock implementation
        return \Mockery::mock(ReporteQuery::class);
    }
}
```

---

### 2.2 Tests para KPIAssembler

```php
<?php

namespace Tests\Unit\Application\Reporte\Assemblers\Movimientos;

use App\Application\Reporte\Assemblers\Movimientos\KPIAssembler;
use App\Application\Reporte\DTOs\Movimientos\KPI\PeriodKPIDTO;
use App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType;
use App\Domains\Reporte\ValueObjects\ReporteQueryResult;
use App\Shared\Domain\Services\Financial\PercentageService;
use Tests\TestCase;

class KPIAssemblerTest extends TestCase
{
    private KPIAssembler $assembler;
    private PercentageService $percentageService;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->percentageService = new PercentageService();
        $this->assembler = new KPIAssembler($this->percentageService);
    }
    
    public function test_supports_kpis_type(): void
    {
        $this->assertTrue(
            $this->assembler->supports(MovimientoReportStatisticType::KPIS)
        );
        $this->assertFalse(
            $this->assembler->supports(MovimientoReportStatisticType::BALANCE_NETO)
        );
    }
    
    public function test_assemble_returns_null_if_no_kpis_result(): void
    {
        $result = new ReporteQueryResult();
        
        $assembled = $this->assembler->assemble($result);
        
        $this->assertNull($assembled);
    }
    
    public function test_assemble_builds_period_kpi_dto(): void
    {
        $mockKPI = $this->createMockKPICollection();
        $result = new ReporteQueryResult();
        $result = $result->add(MovimientoReportStatisticType::KPIS, $mockKPI);
        
        $assembled = $this->assembler->assemble($result);
        
        $this->assertInstanceOf(PeriodKPIDTO::class, $assembled);
        $this->assertNotNull($assembled->totales);
        $this->assertNotNull($assembled->variaciones);
    }
    
    public function test_assemble_calculates_percentage_variations(): void
    {
        $currentKPI = $this->createMockKPICollection(
            ingresos: 1000,
            gastos: 500,
            balance: 500,
            movimientos: 10
        );
        
        $previousKPI = $this->createMockKPICollection(
            ingresos: 800,
            gastos: 400,
            balance: 400,
            movimientos: 8
        );
        
        $result = new ReporteQueryResult();
        $result = $result->add(MovimientoReportStatisticType::KPIS, $currentKPI);
        $result = $result->addPrevious(MovimientoReportStatisticType::KPIS, $previousKPI);
        
        $assembled = $this->assembler->assemble($result);
        
        // 1000 - 800 / 800 * 100 = 25%
        $this->assertEquals(25.0, $assembled->variaciones->ingresos);
    }
    
    private function createMockKPICollection(
        float $ingresos = 0,
        float $gastos = 0,
        float $balance = 0,
        int $movimientos = 0
    ) {
        $mock = \Mockery::mock();
        $mock->shouldReceive('totalIngresos')->andReturn($ingresos);
        $mock->shouldReceive('totalGastos')->andReturn($gastos);
        $mock->shouldReceive('totalBalance')->andReturn($balance);
        $mock->shouldReceive('totalMovimientos')->andReturn($movimientos);
        
        return $mock;
    }
}
```

---

### 2.3 Tests para ReportQueryMapper

```php
<?php

namespace Tests\Unit\Application\Reporte\Mappers;

use App\Application\Reporte\DTOs\GenerateFinancialReportQuery;
use App\Application\Reporte\Mappers\ReportQueryMapper;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use Tests\TestCase;

class ReportQueryMapperTest extends TestCase
{
    private ReportQueryMapper $mapper;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->mapper = app(ReportQueryMapper::class);
    }
    
    public function test_map_creates_reporte_query(): void
    {
        $dto = new GenerateFinancialReportQuery(
            startDate: '2024-01-01',
            endDate: '2024-01-31'
        );
        
        $query = $this->mapper->map($dto);
        
        $this->assertInstanceOf(ReporteQuery::class, $query);
        $this->assertNotNull($query->dateRange);
        $this->assertNotNull($query->granularityStrategy);
    }
    
    public function test_map_uses_default_dates_when_not_provided(): void
    {
        $dto = new GenerateFinancialReportQuery();
        
        $query = $this->mapper->map($dto);
        
        // Should use last 6 months
        $this->assertGreaterThan(150, $query->dateRange->diffDays());
    }
    
    public function test_map_preserves_filter_flags(): void
    {
        $dto = new GenerateFinancialReportQuery(
            startDate: '2024-01-01',
            endDate: '2024-01-31',
            only_categorias_fijas: true
        );
        
        $query = $this->mapper->map($dto);
        
        $this->assertTrue($query->only_categorias_fijas);
    }
    
    public function test_map_converts_ids_array_to_ids_dto(): void
    {
        $dto = new GenerateFinancialReportQuery(
            startDate: '2024-01-01',
            endDate: '2024-01-31',
            categorias: [1, 2, 3]
        );
        
        $query = $this->mapper->map($dto);
        
        $this->assertNotNull($query->categorias);
    }
}
```

---

## 3. TESTS PARA INFRASTRUCTURE LAYER

### 3.1 Tests para EloquentKPIsQueryExecutor (Integración)

```php
<?php

namespace Tests\Feature\Infrastructure\Reporte\Queries\Handlers\Movimientos;

use App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\EloquentKPIsQueryExecutor;
use App\Domains\Reporte\ValueObjects\ReporteQuery;
use App\Domains\Reporte\ValueObjects\DateRange;
use App\Models\Movimiento;
use App\Models\TipoMovimiento;
use DateTimeImmutable;
use Tests\TestCase;

class EloquentKPIsQueryExecutorTest extends TestCase
{
    use RefreshDatabase;
    
    private EloquentKPIsQueryExecutor $handler;
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->handler = app(EloquentKPIsQueryExecutor::class);
    }
    
    public function test_supports_kpis_type(): void
    {
        $this->assertTrue(
            $this->handler->supports(\App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType::KPIS)
        );
    }
    
    public function test_handle_returns_kpi_collection(): void
    {
        // Create test data
        $this->createTestMovimientos();
        
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-01-31')
        );
        
        $query = $this->createReporteQuery($dateRange);
        
        $result = $this->handler->handle($query);
        
        $this->assertNotNull($result);
        $this->assertTrue(method_exists($result, '__iterate'));
    }
    
    public function test_handle_sums_ingresos_correctly(): void
    {
        $this->createTestMovimientos([
            'ingreso' => 1000,
            'gasto' => 500,
        ]);
        
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-01-01'),
            new DateTimeImmutable('2024-01-31')
        );
        
        $query = $this->createReporteQuery($dateRange);
        $result = $this->handler->handle($query);
        
        // Assert ingresos total
        foreach ($result as $kpi) {
            $this->assertEquals(1000, $kpi->totalIngresos());
            break;
        }
    }
    
    public function test_handle_filters_by_date_range(): void
    {
        $this->createTestMovimientos();
        
        $dateRange = new DateRange(
            new DateTimeImmutable('2024-02-01'),
            new DateTimeImmutable('2024-02-29')
        );
        
        $query = $this->createReporteQuery($dateRange);
        $result = $this->handler->handle($query);
        
        // Should be empty since test data is in January
        $this->assertCount(0, iterator_to_array($result));
    }
    
    private function createTestMovimientos(array $amounts = []): void
    {
        $ingresoType = TipoMovimiento::factory()->create(['tipo' => 'ingreso']);
        $gastoType = TipoMovimiento::factory()->create(['tipo' => 'gasto']);
        
        Movimiento::factory()->create([
            'tipo_movimiento_id' => $ingresoType->id,
            'monto' => $amounts['ingreso'] ?? 1000,
            'fecha' => '2024-01-15',
        ]);
        
        Movimiento::factory()->create([
            'tipo_movimiento_id' => $gastoType->id,
            'monto' => $amounts['gasto'] ?? 500,
            'fecha' => '2024-01-20',
        ]);
    }
    
    private function createReporteQuery(DateRange $dateRange): ReporteQuery
    {
        return new ReporteQuery(
            granularityStrategy: \Mockery::mock(),
            dateRange: $dateRange,
        );
    }
}
```

---

## 4. TESTS PARA HTTP LAYER

### 4.1 Tests para ReporteApiController

```php
<?php

namespace Tests\Feature\Http\Controllers\Api\Reporte;

use App\Http\Controllers\Api\Reporte\ReporteApiController;
use Tests\TestCase;

class ReporteApiControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index_returns_json_response(): void
    {
        $response = $this->actingAs($this->createUser())
            ->getJson('/api/reportes');
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'KPIs' => [],
                    'tendencia' => [],
                    'distribuiciones' => [],
                ]
            ]);
    }
    
    public function test_generate_validates_request(): void
    {
        $response = $this->actingAs($this->createUser())
            ->postJson('/api/reportes/generate', []);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['startDate', 'endDate', 'only_categorias_fijas']);
    }
    
    public function test_generate_accepts_valid_request(): void
    {
        $response = $this->actingAs($this->createUser())
            ->postJson('/api/reportes/generate', [
                'startDate' => '2024-01-01',
                'endDate' => '2024-01-31',
                'only_categorias_fijas' => false,
            ]);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'KPIs',
                    'tendencia',
                    'distribuiciones',
                ]
            ]);
    }
    
    private function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}
```

---

## 5. PRUEBAS DE INTEGRACIÓN E2E

### 5.1 Test del Flujo Completo

```php
<?php

namespace Tests\Feature\Reporte;

use App\Models\Movimiento;
use App\Models\TipoMovimiento;
use DateTimeImmutable;
use Tests\TestCase;

class ReporteGenerationFlowTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_complete_report_generation_flow(): void
    {
        // Setup: Create test data
        $user = $this->createUser();
        $this->createTestMovimientos($user);
        
        // Act: Request report
        $response = $this->actingAs($user)
            ->postJson('/api/reportes/generate', [
                'startDate' => '2024-01-01',
                'endDate' => '2024-01-31',
                'only_categorias_fijas' => false,
            ]);
        
        // Assert: Response structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'KPIs' => [
                        'totales' => [
                            'ingresos',
                            'gastos',
                            'balance_neto',
                            'movimientos',
                        ],
                        'variaciones' => [
                            'ingresos',
                            'gastos',
                            'balance_neto',
                            'movimientos',
                        ]
                    ],
                    'tendencia' => [],
                    'distribuiciones' => [],
                ]
            ]);
        
        // Assert: KPI calculations
        $data = $response->json('data.KPIs');
        $this->assertEquals(1000, $data['totales']['ingresos']);
        $this->assertEquals(500, $data['totales']['gastos']);
        $this->assertEquals(500, $data['totales']['balance_neto']);
    }
    
    private function createTestMovimientos($user): void
    {
        $ingresoType = TipoMovimiento::factory()->create([
            'tipo' => 'ingreso',
            'user_id' => $user->id,
        ]);
        
        $gastoType = TipoMovimiento::factory()->create([
            'tipo' => 'gasto',
            'user_id' => $user->id,
        ]);
        
        Movimiento::factory()->create([
            'tipo_movimiento_id' => $ingresoType->id,
            'monto' => 1000,
            'fecha' => '2024-01-15',
            'user_id' => $user->id,
        ]);
        
        Movimiento::factory()->create([
            'tipo_movimiento_id' => $gastoType->id,
            'monto' => 500,
            'fecha' => '2024-01-20',
            'user_id' => $user->id,
        ]);
    }
    
    private function createUser()
    {
        return \App\Models\User::factory()->create();
    }
}
```

---

## 6. CHECKLIST PARA TESTING

### Domain Layer
- [ ] DateRange: Creación, cálculo de días, períodos anteriores
- [ ] ReporteQueryResult: Adición/obtención, validación de tipos, inmutabilidad
- [ ] Enums: Valores, métodos estáticos, lógica de comparación
- [ ] ValueObjects: Encapsulación, inmutabilidad

### Application Layer
- [ ] Handlers: Mapeando DTOs, orquestación de contribuidores
- [ ] Contributors: Filtrado de tipos, lógica de período anterior
- [ ] Assemblers: Transformación de datos, cálculos
- [ ] Mappers: Conversión de DTOs a ValueObjects
- [ ] Resolvers: Localización de implementaciones correctas

### Infrastructure Layer
- [ ] Query Handlers: Construcción de queries, filtros, agrupación
- [ ] Builders: Creación de colecciones
- [ ] Database: Integridad referencial, índices

### HTTP Layer
- [ ] Controllers: Validación de requests, serialización de responses
- [ ] Resources: Estructura JSON, transformación de datos
- [ ] Requests: Reglas de validación

### E2E
- [ ] Flujo completo desde request HTTP hasta respuesta JSON
- [ ] Filtros y búsquedas
- [ ] Manejo de errores
- [ ] Performance con datos grandes
