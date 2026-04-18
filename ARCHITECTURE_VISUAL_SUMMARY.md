# Resumen Visual - Arquitectura y Dependencias

## Diagrama de Capas

```
┌─────────────────────────────────────────────────────────────────┐
│                        HTTP LAYER                               │
│  ReporteApiController → ReporteResource → JSON Response         │
│  (routes/api.php)                                               │
└──────────────────────┬──────────────────────────────────────────┘
                       │ GenerateFinancialReportQuery
                       ▼
┌─────────────────────────────────────────────────────────────────┐
│                    APPLICATION LAYER                            │
│  GenerateReportHandler (Orchestrator)                           │
│  ├─ ReportQueryMapper (Query → ValueObject)                       │
│  ├─ MovimientoReportGenerationContributor                       │
│  │  └─ MovimientoReportQueryOrchestrator                        │
│  │     └─ EloquentKPIsQueryExecutor (Infrastructure)            │
│  ├─ [Otros Contribuidores]                                      │
│  │                                                               │
│  KPIAssembler (DTO a PresentationDTO)                           │
│  ├─ PercentageService                                           │
│  └─ PeriodKPIDTO                                                │
│                                                                  │
│  ReporteQueryResult (Combina todas las contribuciones)         │
└──────────────────────┬──────────────────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────────────────┐
│                    DOMAIN LAYER                                 │
│  VALUE OBJECTS:                                                 │
│  ├─ DateRange                                                   │
│  ├─ ReporteQuery                                                │
│  ├─ ReporteQueryResult                                          │
│  │                                                               │
│  ENUMS:                                                          │
│  ├─ MovimientoReportStatisticType (KPIS, BALANCE_NETO, etc)    │
│                                                                  │
│  CONTRACTS/INTERFACES:                                          │
│  ├─ ReportContributorContract                                   │
│  ├─ AssemblerContract                                           │
│  └─ ReportStatisticTypeContract                                 │
└──────────────────────┬──────────────────────────────────────────┘
                       │
┌──────────────────────▼──────────────────────────────────────────┐
│                  INFRASTRUCTURE LAYER                            │
│  QUERY HANDLERS:                                                │
│  ├─ EloquentKPIsQueryExecutor                                    │
│  ├─ EloquentBalanceNetoQueryExecutor                             │
│  └─ [Otros Handlers]                                            │
│                                                                  │
│  BUILDERS & RESOLVERS:                                          │
│  ├─ EloquentKPIBuilder                                          │
│  ├─ MovimientoQueryRelationResolver                             │
│  └─ ReportGranularityResolver                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Diagrama de Flujo de Datos Completo

```
HTTP REQUEST
    │
    ├─ POST /api/reportes/generate
    ├─ Content: GenerateReporteRequest (validado)
    │
    ▼
ReporteApiController::generate()
    │
    ├─ Extrae: startDate, endDate, categorias, cuentas, only_categorias_fijas
    │
    ▼
GenerateFinancialReportQuery (Data Transfer Object)
    │
    ▼
GenerateReportHandler::handle([types], dto)
    │
    ├─ ReportQueryMapper::map(dto)
    │  │
    │  ├─ Resuelve DateRange (default: últimos 6 meses)
    │  ├─ Resuelve Granularity (día, semana, mes)
    │  ├─ Convierte IDs a IdsDTO
    │  │
    │  └─ Retorna: ReporteQuery (Value Object)
    │
    ├─ Itera sobre Contributors:
    │  │
    │  ├─ MovimientoReportGenerationContributor::shouldContribute([types])
    │  │  └─ ¿Contiene tipos MovimientoReportStatisticType?
    │  │
    │  ├─ Si SÍ → MovimientoReportGenerationContributor::handle(query, types)
    │  │  │
    │  │  └─ MovimientoReportQueryOrchestrator::getMultiple(types, query)
    │  │     │
    │  │     ├─ Para cada tipo, busca handler apropiado:
    │  │     │  │
    │  │     │  ├─ Si es KPIS → EloquentKPIsQueryExecutor
    │  │     │  │  │
    │  │     │  │  ├─ Construye query Eloquent:
    │  │     │  │  │  ├─ SELECT SUM(CASE...), COUNT(*)
    │  │     │  │  │  ├─ FROM movimientos
    │  │     │  │  │  ├─ WHERE fecha BETWEEN ? AND ?
    │  │     │  │  │  └─ GROUP BY {granularity}
    │  │     │  │  │
    │  │     │  │  └─ Retorna: LaravelKPICollection
    │  │     │  │
    │  │     │  ├─ Si es BALANCE_NETO → EloquentBalanceNetoQueryExecutor
    │  │     │  ├─ Si es ... → ...
    │  │     │
    │  │     └─ Retorna: ReporteQueryResult
    │  │
    │  ├─ Para tipos comparativos (KPIS):
    │  │  └─ query.toPreviousPeriod() → consulta período anterior
    │  │     └─ ReporteQueryResult.addPrevious()
    │  │
    │  └─ Retorna: ReporteQueryResult (parcial)
    │
    ├─ Combina resultados de todos los contribuidores:
    │  └─ ReporteQueryResult.merge()
    │
    └─ Retorna: ReporteQueryResult FINAL
       │
       ▼
    ReporteResource::toArray()
       │
       ├─ Itera sobre tipos en resultado
       │
       ├─ Para KPIS:
       │  │
       │  └─ AssemblerResolver::resolve(KPIS, result)
       │     │
       │     └─ KPIAssembler::assemble(result)
       │        │
       │        ├─ Obtiene datos actuales: result.get(KPIS)
       │        ├─ Obtiene datos previos: result.getPrevious(KPIS)
       │        │
       │        ├─ PercentageService::calculatePercentageChange()
       │        │  └─ (current - previous) / |previous| * 100
       │        │
       │        └─ Retorna: PeriodKPIDTO
       │           ├─ TotalsKPIDTO (ingresos, gastos, balance_neto, movimientos)
       │           └─ VariationsKPIDTO (variaciones %)
       │
       ├─ Para otros tipos:
       │  └─ [Otros Assemblers] → [Otros DTOs]
       │
       └─ Estructura final JSON:
          {
            "KPIs": { "totales": {...}, "variaciones": {...} },
            "tendencia": {
              "ingresos_vs_gastos": {...},
              "balance_neto_por_fecha": {...},
              "presupuesto": {...}
            },
            "distribuiciones": {
              "por_categoria": {...}
            }
          }

JSON RESPONSE
```

---

## Matriz de Responsabilidades

| Componente | Responsabilidad Principal | Responsabilidades Secundarias |
|-----------|--------------------------|------------------------------|
| **ReporteApiController** | Exponer endpoints HTTP | Validar requests, serializar respuestas |
| **GenerateFinancialReportQuery** | Transportar datos HTTP → App | - |
| **GenerateReportHandler** | Orquestar generación de reportes | Coordinar contribuidores |
| **ReportQueryMapper** | Mapear DTO → ValueObject | Resolver defaults, convertir tipos |
| **MovimientoReportGenerationContributor** | Contribuir datos Movimientos | Consultar período anterior |
| **MovimientoReportQueryOrchestrator** | Orquestar queries de Movimientos | Buscar handlers correctos |
| **EloquentKPIsQueryExecutor** | Ejecutar query para KPIs | Construir query, filtrar fecha |
| **ReporteQueryResult** | Almacenar resultados | Adición, validación, fusión |
| **KPIAssembler** | Transformar a PresentationDTO | Calcular variaciones |
| **AssemblerResolver** | Localizar assembler | Validar existencia |
| **ReporteResource** | Serializar a JSON | Estructura de respuesta |
| **DateRange** | Encapsular rango de fechas | Cálculos, períodos anteriores |

---

## Flujo de Inyección de Dependencias

```
┌─────────────────────────────────────────────────┐
│     SERVICE PROVIDER (ReporteServiceProvider)    │
│                                                  │
│  Registra en el contenedor:                      │
│                                                  │
│  ├─ GenerateReportHandler                       │
│  │  ├─ Inyecta: ReportQueryMapper               │
│  │  └─ Inyecta: iterable<ReportContributorContract>
│  │                                               │
│  ├─ MovimientoReportGenerationContributor       │
│  │  └─ Inyecta: MovimientoReportQueryOrchestrator
│  │                                               │
│  ├─ MovimientoReportQueryOrchestrator           │
│  │  └─ Inyecta: iterable<ReporteQueryExecutorContract>
│  │                                               │
│  ├─ EloquentKPIsQueryExecutor                    │
│  │  └─ Inyecta: MovimientoQueryRelationResolver │
│  │                                               │
│  ├─ ReportQueryMapper                           │
│  │  ├─ Inyecta: ReportGranularityResolver       │
│  │  ├─ Inyecta: DefaultDateRangeSpecification   │
│  │  └─ Inyecta: IdsSpecification                │
│  │                                               │
│  ├─ KPIAssembler                                │
│  │  └─ Inyecta: PercentageService               │
│  │                                               │
│  ├─ AssemblerResolver                           │
│  │  └─ Inyecta: iterable<AssemblerContract>     │
│  │                                               │
│  └─ ReporteApiController                        │
│     └─ Inyecta: GenerateReportHandler           │
│                                                  │
└─────────────────────────────────────────────────┘
```

---

## Tabla de Dependencias Directas

```
GenerateReportHandler
├── ReportQueryMapper
│   ├── ReportGranularityResolver
│   ├── DefaultDateRangeSpecification
│   └── IdsSpecification
└── iterable<ReportContributorContract>
    └── MovimientoReportGenerationContributor
        └── MovimientoReportQueryOrchestrator
            └── iterable<ReporteQueryExecutorContract>
                ├── EloquentKPIsQueryExecutor
                │   └── MovimientoQueryRelationResolver
                ├── EloquentBalanceNetoQueryExecutor
                └── [otros handlers]

KPIAssembler
└── PercentageService

ReporteApiController
├── GenerateReportHandler
├── ReporteResource
│   └── AssemblerResolver
│       └── iterable<AssemblerContract>
│           ├── KPIAssembler
│           └── [otros assemblers]
└── GenerateReporteRequest (validación)
```

---

## Tipos de Datos Clave

| Tipo | Ubicación | Propósito | Mutable |
|------|-----------|----------|--------|
| `DateRange` | Domain/ValueObjects | Encapsular rango de fechas | ❌ No |
| `ReporteQuery` | Domain/ValueObjects | Parámetros de consulta | ❌ No |
| `ReporteQueryResult` | Domain/ValueObjects | Resultados de consulta | ❌ No (clona) |
| `GenerateFinancialReportQuery` | Application/DTOs | Transportar datos HTTP | ❌ No |
| `PeriodKPIDTO` | Application/DTOs | Presentación de KPIs | ❌ No |
| `LaravelKPICollection` | Infrastructure/Collections | Colección de KPIs | ✅ Sí |
| `ReportStatisticTypeContract` | Domain/Contracts | Tipo de estadística | ❌ No (enum) |

---

## Enums Principales

### MovimientoReportStatisticType (Domain Layer)
```
KPIS                  = 'kpis'
BALANCE_NETO          = 'balance_neto'
INGRESOS_VS_GASTOS    = 'ingresos_vs_gastos'
CATEGORY_DISTRIBUTION = 'category_distribution'
INGRESOS              = 'ingresos'
GASTOS                = 'gastos'

Métodos útiles:
- fullReport()           → Todos los tipos (6)
- homeDashboard()        → Tipos para dashboard (2: KPIS, INGRESOS_VS_GASTOS)
- requiresComparativeData()  → Solo KPIS retorna true
- withComparativeData()   → Array de tipos que requieren período anterior
```

### ReportStatisticType (Application Layer)
```
Combina tipos de múltiples dominios:
- MovimientoReportStatisticType (5 tipos)
- PresupuestoReportStatisticType (USED_BUDGET)

Método:
- statistics() → Array de todos los tipos para UI (6)
```

---

## Especificaciones de Negocio Clave

### 1. Período Anterior
- **SOLO KPIS** requiere consultar período anterior
- El período anterior tiene la **misma duración** que el actual
- **Termina el día antes** de que comience el período actual
- Se consulta **una sola vez** y se reutiliza (optimización)

### 2. Cálculo de Variaciones
```
% de cambio = ((valor_actual - valor_anterior) / |valor_anterior|) * 100

Casos especiales:
- Si valor_anterior = 0 → retorna NULL
- Si divisor = 0 → retorna 0
```

### 3. Rango de Fechas por Defecto
- Si no se proporciona startDate/endDate → **últimos 6 meses**

### 4. Granularidad de Agrupación
- Se resuelve automáticamente según duración del rango
- Ejemplos: daily, weekly, monthly

---

## Rutas HTTP

| Método | Ruta | Handler | DTO | Response |
|--------|------|---------|-----|----------|
| GET | `/api/reportes` | ReporteApiController::index() | GenerateFinancialReportQuery (default) | ReporteResource |
| POST | `/api/reportes/generate` | ReporteApiController::generate() | GenerateFinancialReportQuery (validado) | ReporteResource |

---

## Archivos de Configuración Relacionados

```
app/
├── config/
│   └── (posiblemente config/reportes.php)
│
└── Providers/
   └── (posiblemente ReporteServiceProvider.php)
      └── Registra handlers, contribuidores, assemblers, etc.
```

---

## Checklist de Archivos Principales

| Archivo | Líneas | Tipo | Prioridad |
|---------|--------|------|-----------|
| DateRange.php | ~70 | Value Object | 🔴 Crítica |
| ReporteQueryResult.php | ~121 | Value Object | 🔴 Crítica |
| MovimientoReportStatisticType.php | ~60 | Enum | 🟠 Alta |
| GenerateReportHandler.php | ~60 | Handler | 🔴 Crítica |
| MovimientoReportGenerationContributor.php | ~80 | Contributor | 🟠 Alta |
| KPIAssembler.php | ~60 | Assembler | 🟠 Alta |
| EloquentKPIsQueryExecutor.php | ~50 | Query Handler | 🟠 Alta |
| ReporteApiController.php | ~55 | Controller | 🟠 Alta |
| ReporteResource.php | ~70 | Resource | 🟡 Media |
| GenerateReporteRequest.php | ~30 | Form Request | 🟡 Media |

---

## Notas de Implementación

### Patrones Utilizados
- ✅ **Domain-Driven Design (DDD)**
- ✅ **Service Locator Pattern** (Resolvers)
- ✅ **Strategy Pattern** (GranularityStrategy)
- ✅ **Template Method Pattern** (ReportAssembler)
- ✅ **Observer/Contributor Pattern** (ReportContributors)
- ✅ **Data Transfer Object Pattern** (DTOs)
- ✅ **Value Object Pattern** (DateRange, ReporteQuery, ReporteQueryResult)

### Principios SOLID Aplicados
- ✅ **S**ingle Responsibility: Cada clase tiene una responsabilidad clara
- ✅ **O**pen/Closed: Fácil agregar nuevos handlers y assemblers
- ✅ **L**iskov Substitution: Implementaciones intercambiables vía interfaces
- ✅ **I**nterface Segregation: Interfaces específicas (ReportContributorContract, AssemblerContract)
- ✅ **D**ependency Inversion: Depende de abstracciones, no de implementaciones concretas

### Anti-patterns Evitados
- ✅ NO hay lógica de BD en controladores
- ✅ NO hay lógica de negocio en infraestructura
- ✅ NO hay acoplamiento a framework en Domain
- ✅ NO hay god objects

---

## Mejoras Potenciales

1. **Caché de resultados** en ReporteQueryResult (memoization)
2. **Queues** para reportes grandes (Job)
3. **Exportación** (CSV, PDF) en controllers
4. **Paginación** de resultados grandes
5. **Filtros más complejos** (OR/AND combinations)
6. **Historial** de reportes generados
7. **Comparación multi-período** (no solo anterior)
