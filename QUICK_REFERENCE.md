# Quick Reference - Clases y Métodos

## REFERENCIA RÁPIDA DE CLASES

### Domain Layer - Value Objects

#### DateRange
```php
Namespace: App\Domains\Reporte\ValueObjects

Constructor:
  __construct(DateTimeImmutable $startDate, DateTimeImmutable $endDate)

Métodos públicos:
  diffDays(): int
  getPreviousPeriod(): DateRange
  toPreviousPeriod(): DateRange
  
Métodos estáticos:
  lastSixMonths(): DateRange
  lastMonth(): DateRange

Propiedades públicas (readonly):
  $startDate: DateTimeImmutable
  $endDate: DateTimeImmutable
```

#### ReporteQueryResult
```php
Namespace: App\Domains\Reporte\ValueObjects

Métodos públicos:
  add(ReportStatisticTypeContract $type, mixed $collection): self
  get(ReportStatisticTypeContract $type): mixed
    ↳ Lanza InvalidArgumentException si no existe
  has(ReportStatisticTypeContract $type): bool
  
  addPrevious(ReportStatisticTypeContract $type, mixed $collection): self
  getPrevious(ReportStatisticTypeContract $type): mixed
    ↳ Retorna null si no existe
  hasPrevious(ReportStatisticTypeContract $type): bool
  
  merge(ReporteQueryResult $other): self

Propiedades privadas:
  $results: array<string, mixed>
  $previousResults: array<string, mixed>
```

#### ReporteQuery
```php
Namespace: App\Domains\Reporte\ValueObjects

Constructor:
  __construct(
    ReportGranularityStrategyContract $granularityStrategy,
    DateRange $dateRange,
    bool $only_categorias_fijas = false,
    ?IdsDTO $categorias = null,
    ?IdsDTO $cuentas = null
  )

Métodos públicos:
  toPreviousPeriod(): self

Propiedades públicas (readonly):
  $granularityStrategy: ReportGranularityStrategyContract
  $dateRange: DateRange
  $only_categorias_fijas: bool
  $categorias: ?IdsDTO
  $cuentas: ?IdsDTO
```

---

### Domain Layer - Enums

#### MovimientoReportStatisticType
```php
Namespace: App\Domains\Reporte\Enums\Statistic

Casos del Enum:
  KPIS                  = 'kpis'
  BALANCE_NETO          = 'balance_neto'
  INGRESOS_VS_GASTOS    = 'ingresos_vs_gastos'
  CATEGORY_DISTRIBUTION = 'category_distribution'
  INGRESOS              = 'ingresos'
  GASTOS                = 'gastos'

Métodos (estáticos):
  fullReport(): array
    ↳ Retorna: [KPIS, BALANCE_NETO, INGRESOS_VS_GASTOS, CATEGORY_DISTRIBUTION, INGRESOS, GASTOS]
  
  homeDashboard(): array
    ↳ Retorna: [KPIS, INGRESOS_VS_GASTOS]
  
  withComparativeData(): array
    ↳ Retorna: tipos que requieren período anterior

Métodos (instancia):
  requiresComparativeData(): bool
    ↳ true solo para KPIS
```

---

### Application Layer - DTOs

#### GenerateFinancialReportQuery
```php
Namespace: App\Application\Reporte\DTOs

Constructor:
  __construct(
    ?string $startDate = null,
    ?string $endDate = null,
    ?iterable $cuentas = null,
    ?iterable $categorias = null,
    bool $only_categorias_fijas = false
  )

Propiedades públicas (readonly):
  $startDate: ?string
  $endDate: ?string
  $cuentas: ?iterable
  $categorias: ?iterable
  $only_categorias_fijas: bool
```

---

### Application Layer - Handlers

#### GenerateReportHandler
```php
Namespace: App\Application\Reporte\Handlers

Constructor:
  __construct(
    ReportQueryMapper $mapper,
    iterable $contributors
  )

Métodos públicos:
  handle(array $types, GenerateFinancialReportQuery $data): ReporteQueryResult
    ↳ Genera reporte para tipos específicos
    ↳ Filtra contribuidores que apliquen a los tipos
  
  fullReport(GenerateFinancialReportQuery $data): ReporteQueryResult
    ↳ Genera reporte completo de todos los contribuidores
```

#### MovimientoReportGenerationContributor
```php
Namespace: App\Application\Reporte\Contributors

Constructor:
  __construct(MovimientoReportQueryOrchestrator $queryOrchestrator)

Métodos públicos:
  handle(ReporteQuery $dto, array $types): ReporteQueryResult
    ↳ Genera estadísticas para tipos específicos
    ↳ Consulta período anterior si es necesario (KPIS)
  
  contribute(ReporteQuery $dto): ReporteQueryResult
    ↳ Contribución completa del dominio
  
  shouldContribute(array $requestedTypes): bool
    ↳ true si contiene algún MovimientoReportStatisticType
```

---

### Application Layer - Mappers

#### ReportQueryMapper
```php
Namespace: App\Application\Reporte\Mappers

Constructor:
  __construct(
    ReportGranularityResolver $granularityResolver,
    DefaultDateRangeSpecification $dateRangeSpec,
    IdsSpecification $idsSpec
  )

Métodos públicos:
  map(GenerateFinancialReportQuery $dto): ReporteQuery
    ↳ Mapea DTO a Value Object de dominio
    ↳ Resuelve defaults (6 meses si no hay fechas)
    ↳ Convierte arrays de IDs a IdsDTO

Métodos privados:
  resolveDateRange(GenerateFinancialReportQuery $dto): DateRange
  resolveIds(?iterable $property): ?IdsDTO
```

---

### Application Layer - Orchestrators

#### MovimientoReportQueryOrchestrator
```php
Namespace: App\Application\Reporte\Orchestrators

Constructor:
  __construct(iterable $handlers)

Métodos públicos:
  get(ReportStatisticTypeContract $type, ReporteQuery $dto): mixed
    ↳ Busca handler para tipo y ejecuta
    ↳ Lanza InvalidArgumentException si no encuentra
  
  getMultiple(array $types, ReporteQuery $dto): ReporteQueryResult
    ↳ Ejecuta múltiples queries y combina en ReporteQueryResult
```

---

### Application Layer - Assemblers

#### KPIAssembler
```php
Namespace: App\Application\Reporte\Assemblers\Movimientos

Constructor:
  __construct(PercentageService $percentageService)

Propiedades protegidas:
  $statisticType = MovimientoReportStatisticType::KPIS

Métodos públicos:
  supports(ReportStatisticTypeContract $type): bool
    ↳ true solo para KPIS
  
  assemble(ReporteQueryResult $results): mixed
    ↳ Retorna null si no existe resultado
    ↳ Retorna PeriodKPIDTO con totales y variaciones

Métodos protegidos:
  instanceof(ReportStatisticTypeContract $type): bool
  buildAssemble(ReporteQueryResult $results): PeriodKPIDTO
    ↳ Construye DTO con cálculos de variaciones
```

#### ReportAssembler (Abstract)
```php
Namespace: App\Application\Reporte\Assemblers\Abstracts

Propiedades protegidas:
  $statisticType: ReportStatisticTypeContract

Métodos públicos:
  supports(ReportStatisticTypeContract $type): bool
  assemble(ReporteQueryResult $results): mixed

Métodos abstractos (implementar en subclases):
  abstract protected instanceof(ReportStatisticTypeContract $type): bool
  abstract protected buildAssemble(ReporteQueryResult $results): mixed
```

---

### Application Layer - Resolvers

#### AssemblerResolver
```php
Namespace: App\Application\Reporte\Resolvers

Constructor:
  __construct(iterable $assemblers)

Métodos públicos:
  resolve(
    ReportStatisticTypeContract $type,
    ReporteQueryResult $results
  ): mixed
    ↳ Busca assembler para tipo y lo ejecuta
    ↳ Lanza InvalidArgumentException si no encuentra
  
  has(ReportStatisticTypeContract $type): bool
    ↳ Verifica si existe assembler para tipo
```

---

### Infrastructure Layer - Query Handlers

#### EloquentKPIsQueryExecutor
```php
Namespace: App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent

Constructor:
  __construct(MovimientoQueryRelationResolver $relationResolver)

Métodos públicos:
  supports(ReportStatisticTypeContract $type): bool
    ↳ true solo para KPIS
  
  handle(ReporteQuery $dto): LaravelKPICollection
    ↳ Ejecuta query Eloquent
    ↳ Construye SELECT con sumas condicionales y COUNT
    ↳ Aplica filtros de fecha y relaciones
    ↳ Agrupa por granularidad temporal

Métodos heredados (de EloquentMovimientoTableQueryExecutor):
  getConditionalSumQuery(): string
  getTableRecordsCountQuery(string $column): string
  baseQuery(DateTimeImmutable, DateTimeImmutable, ..., string): QueryBuilder
  movimientos(): QueryBuilder
```

---

### HTTP Layer - Controllers

#### ReporteApiController
```php
Namespace: App\Http\Controllers\Api\Reporte

Constructor:
  __construct(GenerateReportHandler $reportHandler)

Métodos públicos:
  index(): JsonResponse
    ↳ GET /api/reportes
    ↳ Genera reporte con GenerateFinancialReportQuery por defecto
    ↳ Retorna: ReporteResource (JSON)
  
  generate(GenerateReporteRequest $request): JsonResponse
    ↳ POST /api/reportes/generate
    ↳ Valida request
    ↳ Genera reporte con filtros
    ↳ Retorna: ReporteResource (JSON)

Métodos comentados:
  formOptions(): JsonResponse (pendiente)
```

---

### HTTP Layer - Requests

#### GenerateReporteRequest
```php
Namespace: App\Http\Requests\Reporte

Métodos públicos:
  authorize(): bool
    ↳ Retorna true
  
  rules(): array
    ↳ Reglas de validación:
      - startDate: required, date
      - endDate: required, date
      - categorias: nullable, array
      - cuentas: nullable, array
      - only_categorias_fijas: required, boolean
```

---

### HTTP Layer - Resources

#### ReporteResource
```php
Namespace: App\Http\Resources\Reporte

Constructor:
  __construct($resource, AssemblerResolver $assemblerResolver)

Métodos públicos:
  toArray(Request $request): array
    ↳ Estructura respuesta JSON
    ↳ Ensambla datos usando AssemblerResolver
    ↳ Estructura: KPIs, tendencia, distribuiciones

Métodos privados:
  assembleIfPresent($type, ReporteQueryResult $result): mixed
    ↳ Retorna null si tipo no existe en resultado
    ↳ Retorna ensamblaje si existe
```

---

### Shared Services

#### PercentageService
```php
Namespace: App\Shared\Domain\Services\Financial

Métodos públicos:
  calculatePercentageChange(float $current, float $previous): ?float
    ↳ Calcula: ((current - previous) / |previous|) * 100
    ↳ Retorna null si previous = 0
  
  calculatePercentage(float $value, float $divider): float
    ↳ Calcula: (value / divider) * 100
    ↳ Retorna 0 si divider = 0
```

---

## TABLA DE TIPOS DE ESTADÍSTICAS

| Tipo | Enum | Requiere Anterior | Domain | Handler |
|------|------|------------------|--------|---------|
| KPIS | MovimientoReportStatisticType | ✅ Sí | Movimientos | EloquentKPIsQueryExecutor |
| BALANCE_NETO | MovimientoReportStatisticType | ❌ No | Movimientos | EloquentBalanceNetoQueryExecutor |
| INGRESOS_VS_GASTOS | MovimientoReportStatisticType | ❌ No | Movimientos | EloquentIngresosVsGastosQueryExecutor |
| CATEGORY_DISTRIBUTION | MovimientoReportStatisticType | ❌ No | Movimientos | EloquentCategoryDistributionQueryExecutor |
| INGRESOS | MovimientoReportStatisticType | ❌ No | Movimientos | EloquentIngresosQueryExecutor |
| GASTOS | MovimientoReportStatisticType | ❌ No | Movimientos | EloquentGastosQueryExecutor |
| USED_BUDGET | PresupuestoReportStatisticType | ❌ No | Presupuestos | EloquentUsedBudgetQueryExecutor |

---

## ATAJOS DE BÚSQUEDA

### Encontrar por funcionalidad

**¿Dónde agregar un nuevo tipo de estadística?**
1. Agregar case a `MovimientoReportStatisticType` enum
2. Crear handler: `EloquentNewTypeQueryExecutor` en Infrastructure
3. Registrarlo en Service Provider bajo handlers
4. Crear assembler si requiere transformación (Application)
5. Registrar assembler en Service Provider

**¿Dónde cambiar lógica de período anterior?**
- `MovimientoReportGenerationContributor::handle()`
- Específicamente en la lógica de `toPreviousPeriod()`

**¿Dónde cambiar cálculos de variaciones?**
- `PercentageService::calculatePercentageChange()`
- O en assembler específico que use el servicio

**¿Dónde cambiar estructura JSON de respuesta?**
- `ReporteResource::toArray()`
- Define estructura de KPIs, tendencia, distribuiciones

**¿Dónde cambiar rango de fechas por defecto?**
- `ReportQueryMapper::resolveDateRange()`
- O en `DefaultDateRangeSpecification`

---

## EJEMPLOS DE USO

### Generar un reporte
```php
// En controller
$dto = new GenerateFinancialReportQuery(
    startDate: '2024-01-01',
    endDate: '2024-01-31',
    only_categorias_fijas: false
);

$types = [MovimientoReportStatisticType::KPIS];

$result = $this->reportHandler->handle($types, $dto);
// Retorna: ReporteQueryResult
```

### Construir un DateRange
```php
// Últimos 6 meses
$dateRange = DateRange::lastSixMonths();

// Período anterior
$previous = $dateRange->toPreviousPeriod();

// Diferencia en días
$days = $dateRange->diffDays();
```

### Usar ReporteQueryResult
```php
$result = new ReporteQueryResult();

// Agregar resultado
$result = $result->add(MovimientoReportStatisticType::KPIS, $data);

// Verificar y obtener
if ($result->has(MovimientoReportStatisticType::KPIS)) {
    $kpiData = $result->get(MovimientoReportStatisticType::KPIS);
}

// Agregar período anterior
$result = $result->addPrevious(MovimientoReportStatisticType::KPIS, $prevData);

// Obtener período anterior (retorna null si no existe)
$previous = $result->getPrevious(MovimientoReportStatisticType::KPIS);
```

### Calcular variaciones
```php
$percentageService = app(PercentageService::class);

$variation = $percentageService->calculatePercentageChange(1000, 800);
// Retorna: 25.0

$percentage = $percentageService->calculatePercentage(500, 1000);
// Retorna: 50.0
```

---

## VALIDACIÓN Y ERRORES

### InvalidArgumentException
Lanzada por:
- `ReporteQueryResult::get()` - cuando tipo no existe
- `MovimientoReportQueryOrchestrator::get()` - cuando no hay handler
- `AssemblerResolver::resolve()` - cuando no hay assembler

### Validación en FormRequest
`GenerateReporteRequest` valida:
- startDate: requerido, debe ser fecha válida
- endDate: requerido, debe ser fecha válida
- only_categorias_fijas: requerido, debe ser booleano
- categorias: opcional, debe ser array si se proporciona
- cuentas: opcional, debe ser array si se proporciona

---

## CONFIGURACIÓN ESPERADA

El proyecto espera que exista un Service Provider (posiblemente `ReporteServiceProvider.php`) que registre:

**Contributors:**
- MovimientoReportGenerationContributor
- PresupuestoReportGenerationContributor
- [otros...]

**Handlers:**
- EloquentKPIsQueryExecutor
- EloquentBalanceNetoQueryExecutor
- EloquentIngresosVsGastosQueryExecutor
- [otros...]

**Assemblers:**
- KPIAssembler
- BalanceNetoAssembler
- [otros...]

**Resolvers:**
- ReportGranularityResolver
- MovimientoQueryRelationResolver
- [otros...]

**Servicios:**
- PercentageService
- [otros...]
