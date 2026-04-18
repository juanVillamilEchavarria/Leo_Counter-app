# Investigación de Estructura del Proyecto - Leo Counter App

## Resumen Ejecutivo
Este documento proporciona un análisis detallado de las clases principales del sistema de reportes financieros, organizadas por capas: Domain, Application e Infrastructure. Se incluye información sobre métodos principales, dependencias y responsabilidades.

---

## 1. CAPA DOMAIN (Lógica de Negocio)

### 1.1 Value Objects

#### 📍 `DateRange`
- **Ubicación:** [app/Domains/Reporte/ValueObjects/DateRange.php](app/Domains/Reporte/ValueObjects/DateRange.php)
- **Tipo:** Value Object (Immutable)
- **Namespace:** `App\Domains\Reporte\ValueObjects`

**Responsabilidades:**
- Encapsula un rango de fechas con fecha de inicio y fin
- Proporciona cálculos sobre el rango de fechas
- Genera períodos anteriores para análisis comparativos

**Propiedades Públicas:**
```php
readonly DateTimeImmutable $startDate
readonly DateTimeImmutable $endDate
```

**Métodos Principales:**
- `diffDays(): int` - Obtiene la diferencia en días entre las fechas
- `getPreviousPeriod(): self` - Genera un nuevo DateRange del período anterior
- `toPreviousPeriod(): self` - Alias de getPreviousPeriod()
- `lastSixMonths(): self` (static) - Instancia un rango de 6 meses
- `lastMonth(): self` (static) - Instancia un rango de 1 mes

**Dependencias:**
- Extiende de `App\Shared\Domain\ValueObjects\ValueObject`
- `DateTimeImmutable` (PHP built-in)
- `DateInterval` (PHP built-in)

---

#### 📍 `ReporteQueryResult`
- **Ubicación:** [app/Domains/Reporte/ValueObjects/ReporteQueryResult.php](app/Domains/Reporte/ValueObjects/ReporteQueryResult.php)
- **Tipo:** Value Object (Immutable con clonación)
- **Namespace:** `App\Domains\Reporte\ValueObjects`

**Responsabilidades:**
- Almacena resultados de consultas de reportes con soporte para períodos anteriores
- Permite acceso tipado a resultados mediante enums de estadísticas
- Proporciona métodos de validación y fusión de resultados

**Propiedades Privadas:**
```php
private array $results = [];                 // array<string, mixed>
private array $previousResults = [];         // array<string, mixed>
```

**Métodos Principales:**
- `add(ReportStatisticTypeContract $type, mixed $collection): self` - Añade un resultado
- `get(ReportStatisticTypeContract $type): mixed` - Obtiene resultado (lanza excepción si no existe)
- `has(ReportStatisticTypeContract $type): bool` - Verifica si existe resultado
- `addPrevious(ReportStatisticTypeContract $type, mixed $collection): self` - Añade resultado del período anterior
- `getPrevious(ReportStatisticTypeContract $type): mixed` - Obtiene resultado anterior (retorna null si no existe)
- `hasPrevious(ReportStatisticTypeContract $type): bool` - Verifica si existe resultado anterior
- `merge(ReporteQueryResult $other): self` - Combina resultados de otro QueryResult

**Dependencias:**
- `App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract` (interfaz)

---

#### 📍 `ReporteQuery`
- **Ubicación:** [app/Domains/Reporte/ValueObjects/ReporteQuery.php](app/Domains/Reporte/ValueObjects/ReporteQuery.php)
- **Tipo:** Value Object
- **Namespace:** `App\Domains\Reporte\ValueObjects`

**Responsabilidades:**
- Encapsula todos los parámetros necesarios para ejecutar una consulta de reporte
- Soporta filtros por categorías, cuentas y granularidad temporal

**Propiedades Públicas:**
```php
ReportGranularityStrategyContract $granularityStrategy
DateRange $dateRange
bool $only_categorias_fijas = false
?IdsDTO $categorias = null
?IdsDTO $cuentas = null
```

**Métodos Principales:**
- `toPreviousPeriod(): self` - Genera una nueva consulta desplazada al período anterior

**Dependencias:**
- `App\Domains\Reporte\Contracts\Strategies\ReportGranularityStrategyContract`
- `App\Shared\DTOs\Querys\IdsDTO`

---

### 1.2 Enums de Estadísticas

#### 📍 `MovimientoReportStatisticType`
- **Ubicación:** [app/Domains/Reporte/Enums/Statistic/MovimientoReportStatisticType.php](app/Domains/Reporte/Enums/Statistic/MovimientoReportStatisticType.php)
- **Tipo:** Enum respaldado por string (implementa ReportStatisticTypeContract)
- **Namespace:** `App\Domains\Reporte\Enums\Statistic`

**Responsabilidades:**
- Define todos los tipos de estadísticas disponibles para movimientos
- Proporciona métodos de consulta para agrupaciones de tipos
- Determina qué tipos requieren datos comparativos

**Casos (Values):**
```php
KPIS = 'kpis'
BALANCE_NETO = 'balance_neto'
INGRESOS_VS_GASTOS = 'ingresos_vs_gastos'
CATEGORY_DISTRIBUTION = 'category_distribution'
INGRESOS = 'ingresos'
GASTOS = 'gastos'
```

**Métodos Principales:**
- `fullReport(): array` (static) - Retorna todos los tipos
- `homeDashboard(): array` (static) - Retorna tipos para dashboard de inicio
- `requiresComparativeData(): bool` - Determina si requiere período anterior
- `withComparativeData(): array` (static) - Retorna tipos que requieren comparación

**Dependencias:**
- Implementa `App\Domains\Reporte\Contracts\Enums\ReportStatisticTypeContract`

---

## 2. CAPA APPLICATION (Casos de Uso)

### 2.1 DTOs (Data Transfer Objects)

#### 📍 `GenerateFinancialReportQuery`
- **Ubicación:** [app/Application/Reporte/DTOs/GenerateFinancialReportQuery.php](app/Application/Reporte/DTOs/GenerateFinancialReportQuery.php)
- **Tipo:** DTO
- **Namespace:** `App\Application\Reporte\DTOs`

**Responsabilidades:**
- Transporta datos desde la capa HTTP hasta la capa de aplicación
- Representa filtros de reporte y rango de fechas

**Propiedades Públicas (Readonly):**
```php
?string $startDate = null
?string $endDate = null
?iterable $cuentas = null
?iterable $categorias = null
bool $only_categorias_fijas = false
```

**Dependencias:**
- Extiende `App\Shared\Abstracts\DTOs\DTO`

---

### 2.2 Handlers (Casos de Uso)

#### 📍 `GenerateReportHandler`
- **Ubicación:** [app/Application/Reporte/Handlers/GenerateReportHandler.php](app/Application/Reporte/Handlers/GenerateReportHandler.php)
- **Tipo:** Handler / Dispatcher (Caso de Uso Compuesto)
- **Namespace:** `App\Application\Reporte\Handlers`

**Responsabilidades:**
- Punto único de entrada para generación de reportes financieros
- Orquesta contribuciones de diferentes dominios
- Soporta reportes parciales (tipos específicos) o completos

**Propiedades Privadas:**
```php
private readonly ReportQueryMapper $mapper
private readonly iterable $contributors        // array<ReportContributorContract>
```

**Métodos Principales:**
- `handle(array $types, GenerateFinancialReportQuery $data): ReporteQueryResult` - Genera reporte con tipos específicos
- `fullReport(GenerateFinancialReportQuery $data): ReporteQueryResult` - Genera reporte completo de todos los dominios

**Flujo de Ejecución:**
1. Mapea GenerateFinancialReportQuery a ReporteQuery
2. Itera sobre contribuidores registrados
3. Filtra contribuidores que apliquen a los tipos solicitados
4. Combina resultados de cada contribuidor

**Dependencias:**
- `App\Application\Reporte\Mappers\ReportQueryMapper`
- `App\Application\Reporte\Contracts\ReportContributorContract` (iterable)

---

#### 📍 `MovimientoReportGenerationContributor`
- **Ubicación:** [app/Application/Reporte/Contributors/MovimientoReportGenerationContributor.php](app/Application/Reporte/Contributors/MovimientoReportGenerationContributor.php)
- **Tipo:** Contribuidor (implementa ReportContributorContract)
- **Namespace:** `App\Application\Reporte\Contributors`

**Responsabilidades:**
- Genera estadísticas del dominio Movimientos
- Consulta datos del período anterior cuando aplique
- Participa en la construcción del reporte global

**Propiedades Privadas:**
```php
private readonly MovimientoReportQueryOrchestrator $queryOrchestrator
```

**Métodos Principales:**
- `handle(ReporteQuery $dto, array $types): ReporteQueryResult` - Genera estadísticas de tipos específicos
- `contribute(ReporteQuery $dto): ReporteQueryResult` - Contribución completa del dominio
- `shouldContribute(array $requestedTypes): bool` - Determina si debe ejecutarse

**Flujo Especial:**
- Para tipos comparativos (KPIS), reutiliza DTO del período anterior
- Evita consultas duplicadas del período anterior

**Dependencias:**
- `App\Application\Reporte\Orchestrators\MovimientoReportQueryOrchestrator`
- `App\Domains\Reporte\Enums\Statistic\MovimientoReportStatisticType`
- `App\Application\Reporte\Contracts\ReportContributorContract` (implementa)

---

### 2.3 Orchestrators

#### 📍 `MovimientoReportQueryOrchestrator`
- **Ubicación:** [app/Application/Reporte/Orchestrators/MovimientoReportQueryOrchestrator.php](app/Application/Reporte/Orchestrators/MovimientoReportQueryOrchestrator.php)
- **Tipo:** Orchestrator (implementa DomainReportQueryOrchestrator)
- **Namespace:** `App\Application\Reporte\Orchestrators`

**Responsabilidades:**
- Orquesta consultas de handlers de infraestructura para el dominio Movimientos
- Busca el handler correcto para cada tipo de estadística
- Combina múltiples consultas en un ReporteQueryResult

**Propiedades Privadas:**
```php
private readonly iterable $handlers        // array<ReporteQueryExecutorContract>
```

**Métodos Principales:**
- `get(ReportStatisticTypeContract $type, ReporteQuery $dto): mixed` - Obtiene un tipo específico
- `getMultiple(array $types, ReporteQuery $dto): ReporteQueryResult` - Obtiene múltiples tipos

**Comportamiento de Error:**
- Lanza `InvalidArgumentException` si no encuentra handler para un tipo

**Dependencias:**
- Iterables de handlers que implementan `App\Application\Reporte\Contracts\Queries\ReporteQueryExecutorContract`

---

### 2.4 Mappers

#### 📍 `ReportQueryMapper`
- **Ubicación:** [app/Application/Reporte/Mappers/ReportQueryMapper.php](app/Application/Reporte/Mappers/ReportQueryMapper.php)
- **Tipo:** Mapper
- **Namespace:** `App\Application\Reporte\Mappers`

**Responsabilidades:**
- Transforma GenerateFinancialReportQuery a ReporteQuery (Value Object de dominio)
- Resuelve rango de fechas con especificación de dominio
- Convierte IDs en objetos IdsDTO

**Propiedades Privadas:**
```php
private readonly ReportGranularityResolver $granularityResolver
private readonly DefaultDateRangeSpecification $dateRangeSpec
private readonly IdsSpecification $idsSpec
```

**Métodos Principales:**
- `map(GenerateFinancialReportQuery $dto): ReporteQuery` - Mapea DTO a Value Object
- `resolveDateRange(GenerateFinancialReportQuery $dto): DateRange` (privado) - Resuelve rango de fechas
- `resolveIds(?iterable $property): ?IdsDTO` (privado) - Convierte IDs a DTO

**Lógica de Rango Predeterminado:**
- Si startDate/endDate no satisfacen la especificación, usa últimos 6 meses

**Dependencias:**
- `App\Application\Reporte\Resolvers\Granularity\ReportGranularityResolver`
- `App\Application\Reporte\Specifications\DefaultDateRangeSpecification`
- `App\Application\Reporte\Specifications\IdsSpecification`

---

### 2.5 Assemblers

#### 📍 `KPIAssembler`
- **Ubicación:** [app/Application/Reporte/Assemblers/Movimientos/KPIAssembler.php](app/Application/Reporte/Assemblers/Movimientos/KPIAssembler.php)
- **Tipo:** Assembler (implementa AssemblerContract, extiende ReportAssembler)
- **Namespace:** `App\Application\Reporte\Assemblers\Movimientos`

**Responsabilidades:**
- Transforma ReporteQueryResult a PeriodKPIDTO para presentación
- Calcula variaciones porcentuales comparando períodos
- Enriquece datos con lógica de negocio

**Propiedades Protegidas:**
```php
protected ReportStatisticTypeContract $statisticType = MovimientoReportStatisticType::KPIS
```

**Propiedades Privadas:**
```php
private readonly PercentageService $percentageService
```

**Métodos Principales:**
- `instanceof(ReportStatisticTypeContract $type): bool` - Valida tipo de estadística
- `buildAssemble(ReporteQueryResult $results): PeriodKPIDTO` - Construye DTO de KPIs

**Flujo de Ensamblaje:**
1. Obtiene resultados actuales de KPIS
2. Obtiene resultados del período anterior si existen
3. Calcula variaciones porcentuales usando PercentageService
4. Retorna PeriodKPIDTO con totales y variaciones

**DTOs Generados:**
- `PeriodKPIDTO` (contiene totales y variaciones)
  - `TotalsKPIDTO`: ingresos, gastos, balance_neto, movimientos
  - `VariationsKPIDTO`: porcentajes de cambio

**Dependencias:**
- `App\Shared\Domain\Services\Financial\PercentageService`
- Extiende `App\Application\Reporte\Assemblers\Abstracts\ReportAssembler`
- Implementa `App\Application\Reporte\Contracts\AssemblerContract`

---

#### 📍 `ReportAssembler` (Clase Base Abstracta)
- **Ubicación:** [app/Application/Reporte/Assemblers/Abstracts/ReportAssembler.php](app/Application/Reporte/Assemblers/Abstracts/ReportAssembler.php)
- **Tipo:** Clase Abstracta
- **Namespace:** `App\Application\Reporte\Assemblers\Abstracts`

**Responsabilidades:**
- Proporciona implementación base para todos los assemblers
- Garantiza validación de tipos y retorno de null si no existe resultado

**Propiedades Protegidas:**
```php
protected ReportStatisticTypeContract $statisticType
```

**Métodos Principales:**
- `supports(ReportStatisticTypeContract $type): bool` - Determina si soporta el tipo
- `assemble(ReporteQueryResult $results): mixed` - Ensambla con validación

**Métodos Abstractos (que deben implementar subclases):**
- `instanceof(ReportStatisticTypeContract $type): bool` - Validación de instancia
- `buildAssemble(ReporteQueryResult $results): mixed` - Construcción real del ensamblaje

**Dependencias:**
- `App\Application\Reporte\Contracts\AssemblerContract`

---

### 2.6 Resolvers

#### 📍 `AssemblerResolver`
- **Ubicación:** [app/Application/Reporte/Resolvers/AssemblerResolver.php](app/Application/Reporte/Resolvers/AssemblerResolver.php)
- **Tipo:** Resolver
- **Namespace:** `App\Application\Reporte\Resolvers`

**Responsabilidades:**
- Busca el assembler correcto para un tipo de estadística
- Valida existencia de assemblers antes de usarlos
- Genera ensamblajes de reportes

**Propiedades Privadas:**
```php
private readonly iterable $assemblers
```

**Métodos Principales:**
- `resolve(ReportStatisticTypeContract $type, ReporteQueryResult $results): mixed` - Busca y ejecuta assembler
- `has(ReportStatisticTypeContract $type): bool` - Verifica existencia de assembler

**Comportamiento de Error:**
- Lanza `InvalidArgumentException` si no encuentra assembler para un tipo

**Dependencias:**
- Iterables de assemblers que implementan `App\Application\Reporte\Contracts\AssemblerContract`

---

## 3. CAPA INFRASTRUCTURE (Detalles Técnicos)

### 3.1 Query Handlers

#### 📍 `EloquentKPIsQueryExecutor`
- **Ubicación:** [app/Infrastructure/Reporte/Queries/Handlers/Movimientos/Eloquent/EloquentKPIsQueryExecutor.php](app/Infrastructure/Reporte/Queries/Handlers/Movimientos/Eloquent/EloquentKPIsQueryExecutor.php)
- **Tipo:** Query Handler (implementa ReporteQueryExecutorContract)
- **Namespace:** `App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent`

**Responsabilidades:**
- Ejecuta consultas Eloquent para obtener KPIs de movimientos
- Agrupa por granularidad temporal
- Calcula totales de ingresos, gastos y cantidad de movimientos

**Propiedades Privadas:**
```php
private readonly MovimientoQueryRelationResolver $relationResolver
```

**Métodos Principales:**
- `supports(ReportStatisticTypeContract $type): bool` - Soporta solo KPIS
- `handle(ReporteQuery $dto): LaravelKPICollection` - Ejecuta consulta

**SQL Equivalente (generado internamente):**
```sql
SELECT
  COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS total_ingresos,
  COALESCE(SUM(CASE WHEN tipo_movimiento_id = ? THEN monto END), 0) AS total_gastos,
  COUNT(movimientos.id) AS total_movimientos,
  {granularity} as fecha
FROM movimientos
WHERE fecha BETWEEN ? AND ?
GROUP BY {granularity}
```

**Métodos Heredados (de EloquentMovimientoTableQueryExecutor):**
- `getConditionalSumQuery(): string` - Genera condición SUM con CASE
- `getTableRecordsCountQuery(string $column): string` - Genera COUNT
- `baseQuery(...): QueryBuilder` - Aplica filtros de fecha y relaciones
- `movimientos(): QueryBuilder` - Obtiene tabla de movimientos

**Dependencias:**
- `App\Infrastructure\Reporte\Queries\Handlers\Movimientos\Eloquent\Abstracts\EloquentMovimientoTableQueryExecutor`
- `App\Infrastructure\Reporte\Resolvers\Queries\Handlers\MovimientoQueryRelationResolver`
- `App\Infrastructure\Reporte\Builders\Eloquent\EloquentKPIBuilder`
- `App\Infrastructure\Reporte\Collections\Laravel\Movimientos\LaravelKPICollection`

**Flujo de Ejecución:**
1. Define SELECT con cálculos de suma condicional y contador
2. Aplica filtros de fecha mediante baseQuery()
3. Resuelve relaciones necesarias
4. Agrupa por granularidad temporal
5. Construye colección de KPIs

---

## 4. CAPA HTTP (Presentación)

### 4.1 Controllers

#### 📍 `ReporteApiController`
- **Ubicación:** [app/Http/Controllers/Api/Reporte/ReporteApiController.php](app/Http/Controllers/Api/Reporte/ReporteApiController.php)
- **Tipo:** Controller API
- **Namespace:** `App\Http\Controllers\Api\Reporte`

**Responsabilidades:**
- Expone endpoints HTTP para reportes
- Delega lógica a handlers de aplicación
- Serializa respuestas usando Resources

**Propiedades Privadas:**
```php
private readonly GenerateReportHandler $reportHandler
```

**Métodos Principales:**
- `index(): JsonResponse` - Genera reporte completo con rango predeterminado
- `generate(GenerateReporteRequest $request): JsonResponse` - Genera reporte con filtros personalizados

**Flujo:**
1. Valida request usando GenerateReporteRequest
2. Convierte request a GenerateFinancialReportQuery
3. Llama al handler con tipos de estadísticas
4. Serializa resultado usando ReporteResource

**Métodos Comentados:**
- `formOptions()` - Pendiente de implementación

**Rutas Asociadas:**
- `GET /api/reportes` → index()
- `POST /api/reportes/generate` → generate()

**Dependencias:**
- `App\Application\Reporte\Handlers\GenerateReportHandler`
- `App\Http\Requests\Reporte\GenerateReporteRequest`
- `App\Http\Resources\Reporte\ReporteResource`

---

#### 📍 `ReporteController`
- **Ubicación:** [app/Http/Controllers/Reporte/ReporteController.php](app/Http/Controllers/Reporte/ReporteController.php)
- **Tipo:** Controller Web
- **Namespace:** `App\Http\Controllers\Reporte`

**Responsabilidades:**
- Renderiza vista de reportes Inertia.js

**Métodos Principales:**
- `index(): InertiaResponse` - Renderiza página de reportes

**Ruta Asociada:**
- `GET /reportes` → index()

---

### 4.2 Requests (Form Requests)

#### 📍 `GenerateReporteRequest`
- **Ubicación:** [app/Http/Requests/Reporte/GenerateReporteRequest.php](app/Http/Requests/Reporte/GenerateReporteRequest.php)
- **Tipo:** Form Request
- **Namespace:** `App\Http\Requests\Reporte`

**Responsabilidades:**
- Valida entrada de generación de reportes
- Define reglas de validación

**Reglas de Validación:**
```php
'startDate'              => ['required', 'date']
'endDate'                => ['required', 'date']
'categorias'             => ['nullable', 'array']
'cuentas'                => ['nullable', 'array']
'only_categorias_fijas'  => ['required', 'boolean']
```

---

### 4.3 Resources (API Resources)

#### 📍 `ReporteResource`
- **Ubicación:** [app/Http/Resources/Reporte/ReporteResource.php](app/Http/Resources/Reporte/ReporteResource.php)
- **Tipo:** JSON Resource
- **Namespace:** `App\Http\Resources\Reporte`

**Responsabilidades:**
- Serializa ReporteQueryResult a JSON para respuesta HTTP
- Ensambla datos usando AssemblerResolver
- Estructura respuesta por áreas temáticas (KPIs, tendencias, distribuciones)

**Propiedades Privadas:**
```php
private readonly AssemblerResolver $assemblerResolver
```

**Métodos Principales:**
- `toArray(Request $request): array` - Transforma recurso a array serializable

**Estructura de Salida:**
```json
{
  "KPIs": {...},
  "tendencia": {
    "ingresos_vs_gastos": {...},
    "balance_neto_por_fecha": {...},
    "presupuesto": {...}
  },
  "distribuiciones": {
    "por_categoria": {...}
  }
}
```

**Métodos Privados:**
- `assembleIfPresent($type, ReporteQueryResult $result): mixed` - Ensambla si existe resultado

**Dependencias:**
- `App\Application\Reporte\Resolvers\AssemblerResolver`

---

## 5. SERVICIOS COMPARTIDOS

### 📍 `PercentageService`
- **Ubicación:** [app/Shared/Domain/Services/Financial/PercentageService.php](app/Shared/Domain/Services/Financial/PercentageService.php)
- **Tipo:** Servicio de Dominio
- **Namespace:** `App\Shared\Domain\Services\Financial`

**Responsabilidades:**
- Cálculos de porcentajes y cambios porcentuales

**Métodos Principales:**
- `calculatePercentageChange(float $currentValue, float $previousValue): ?float` - Calcula % de cambio
- `calculatePercentage(float $value, float $divider): float` - Calcula porcentaje

**Comportamiento Especial:**
- Retorna null si previousValue es 0 en calculatePercentageChange()
- Retorna 0 si divider es 0 en calculatePercentage()

---

## 6. ENUMS DE APLICACIÓN

### 📍 `ReportStatisticType`
- **Ubicación:** [app/Application/Reporte/Enums/Statistics/ReportStatisticType.php](app/Application/Reporte/Enums/Statistics/ReportStatisticType.php)
- **Tipo:** Enum (implementa ReportStatisticTypeContract)
- **Namespace:** `App\Application\Reporte\Enums\Statistics`

**Responsabilidades:**
- Define estadísticas permitidas en la interfaz de reportes
- Combina tipos de múltiples dominios (Movimientos, Presupuestos)

**Métodos Principales:**
- `statistics(): array` (static) - Retorna todos los tipos disponibles para la UI

**Estadísticas Incluidas:**
- MovimientoReportStatisticType::CATEGORY_DISTRIBUTION
- MovimientoReportStatisticType::INGRESOS_VS_GASTOS
- MovimientoReportStatisticType::KPIS
- MovimientoReportStatisticType::BALANCE_NETO
- PresupuestoReportStatisticType::USED_BUDGET

---

## 7. CONTRATOS (Interfaces)

### 📍 `ReportContributorContract`
- **Ubicación:** [app/Application/Reporte/Contracts/ReportContributorContract.php](app/Application/Reporte/Contracts/ReportContributorContract.php)
- **Namespace:** `App\Application\Reporte\Contracts`

**Métodos Definidos:**
- `handle(ReporteQuery $dto, array $types): ReporteQueryResult`
- `contribute(ReporteQuery $dto): ReporteQueryResult`
- `shouldContribute(array $requestedTypes): bool`

---

### 📍 `AssemblerContract`
- **Ubicación:** [app/Application/Reporte/Contracts/AssemblerContract.php](app/Application/Reporte/Contracts/AssemblerContract.php)
- **Namespace:** `App\Application\Reporte\Contracts`

**Métodos Definidos:**
- `supports(ReportStatisticTypeContract $type): bool`
- `assemble(ReporteQueryResult $results): mixed`

---

## 8. DIAGRAMA DE FLUJO DE DATOS

```
HTTP Request (GenerateReporteRequest)
    ↓
ReporteApiController::generate()
    ↓
GenerateFinancialReportQuery (DTO)
    ↓
GenerateReportHandler::handle()
    ├─ ReportQueryMapper::map()
    │  ├─ ReportGranularityResolver
    │  ├─ DefaultDateRangeSpecification
    │  └─ IdsSpecification
    │  → ReporteQuery (Value Object)
    │
    └─ Iterable<ReportContributorContract>
        ├─ MovimientoReportGenerationContributor
        │  ├─ MovimientoReportQueryOrchestrator
        │  │  ├─ EloquentKPIsQueryExecutor
        │  │  │  └─ LaravelKPICollection
        │  │  ├─ EloquentBalanceNetoQueryExecutor
        │  │  └─ [otros handlers...]
        │  │
        │  └─ → ReporteQueryResult
        │
        └─ [otros contribuidores...]
            └─ → ReporteQueryResult
        
        → ReporteQueryResult (combinado)

ReporteResource::toArray()
    └─ AssemblerResolver::resolve()
        ├─ KPIAssembler
        │  ├─ PercentageService
        │  └─ → PeriodKPIDTO
        │
        └─ [otros assemblers...]
            └─ → [otros DTOs]

JSON Response
```

---

## 9. PUNTOS CLAVE PARA TESTING

### Domain Layer
- **DateRange:** Fecha inicial/final, cálculo de días, períodos anteriores
- **ReporteQueryResult:** Adición/obtención de resultados, validación de tipos, fusión
- **MovimientoReportStatisticType:** Tipos de enum, agrupaciones predefinidas, detección de comparación

### Application Layer
- **GenerateReportHandler:** Orquestación de contribuidores, filtrado de tipos
- **MovimientoReportGenerationContributor:** Logica de períodos anteriores, reutilización de DTOs
- **KPIAssembler:** Cálculos de variaciones, ensamblaje de DTOs
- **ReportQueryMapper:** Mapeo de DTO a Value Objects, defaults de fecha

### Infrastructure Layer
- **EloquentKPIsQueryExecutor:** Construcción de queries Eloquent, filtros de fecha, agrupación
- **Resolvers & Builders:** Resolución de relaciones, construcción de colecciones

### HTTP Layer
- **ReporteApiController:** Validación de requests, serialización de responses
- **ReporteResource:** Estructura JSON, ensamblaje condicional

---

## 10. DEPENDENCIAS INYECTADAS

| Clase | Dependencias |
|-------|-------------|
| `GenerateReportHandler` | `ReportQueryMapper`, `iterable<ReportContributorContract>` |
| `MovimientoReportGenerationContributor` | `MovimientoReportQueryOrchestrator` |
| `KPIAssembler` | `PercentageService` |
| `ReportQueryMapper` | `ReportGranularityResolver`, `DefaultDateRangeSpecification`, `IdsSpecification` |
| `AssemblerResolver` | `iterable<AssemblerContract>` |
| `ReporteApiController` | `GenerateReportHandler` |
| `ReporteResource` | `AssemblerResolver` |
| `EloquentKPIsQueryExecutor` | `MovimientoQueryRelationResolver` |

---

## 11. CONFIGURACIÓN Y PROVIDERS

Las dependencias probablemente se registran en un Service Provider (posiblemente `ReporteServiceProvider`):
- Registro de contribuidores (MovimientoReportGenerationContributor, etc.)
- Registro de handlers (EloquentKPIsQueryExecutor, etc.)
- Registro de assemblers (KPIAssembler, etc.)
- Binding de resolvers e interfaces

---

## Notas Finales

Este proyecto implementa una arquitectura **Domain-Driven Design (DDD)** bien estructurada con:
- **Separación clara de capas** (Domain, Application, Infrastructure, HTTP)
- **Value Objects** para encapsulación de datos
- **Handlers y Orchestrators** para orquestación
- **Assemblers** para transformación de datos
- **Resolvers** para localización de implementaciones
- **Inyección de dependencias** completa

Para crear tests efectivos, se debe considerar:
1. Tests unitarios para Value Objects (DateRange, ReporteQueryResult)
2. Tests unitarios para Enums y sus métodos
3. Tests de integración para Handlers y Orchestrators
4. Tests de integración para Query Handlers con BD de prueba
5. Tests para Assemblers con datos mocked
6. Tests de integración E2E para Controllers
