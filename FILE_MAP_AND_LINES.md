# Mapa de Archivos - Líneas Importantes

Este documento proporciona una guía de referencia para encontrar rápidamente fragmentos de código específicos.

---

## Domain Layer Value Objects

### DateRange.php
[app/Domains/Reporte/ValueObjects/DateRange.php](app/Domains/Reporte/ValueObjects/DateRange.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Clase | 16-20 | Definición de la clase y propiedades |
| Constructor | 17-21 | Constructor con parámetros readonly |
| diffDays() | 26-29 | Cálculo de diferencia en días |
| getPreviousPeriod() | 31-39 | Genera período anterior con misma duración |
| lastSixMonths() | 52-58 | Factory para 6 meses |
| lastMonth() | 63-69 | Factory para 1 mes |

---

### ReporteQueryResult.php
[app/Domains/Reporte/ValueObjects/ReporteQueryResult.php](app/Domains/Reporte/ValueObjects/ReporteQueryResult.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Propiedades | 21-33 | Arrays para resultados actuales y anteriores |
| add() | 35-42 | Agregar resultado (retorna clone) |
| get() | 51-58 | Obtener resultado con validación |
| has() | 60-64 | Verificar existencia de resultado |
| addPrevious() | 71-80 | Agregar resultado del período anterior |
| getPrevious() | 89-95 | Obtener resultado anterior (nullable) |
| hasPrevious() | 104-110 | Verificar existencia de resultado anterior |

---

### ReporteQuery.php
[app/Domains/Reporte/ValueObjects/ReporteQuery.php](app/Domains/Reporte/ValueObjects/ReporteQuery.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Propiedades | 11-17 | Constructor con todos los parámetros |
| toPreviousPeriod() | 24-33 | Convierte a período anterior manteniendo filtros |

---

## Domain Layer Enums

### MovimientoReportStatisticType.php
[app/Domains/Reporte/Enums/Statistic/MovimientoReportStatisticType.php](app/Domains/Reporte/Enums/Statistic/MovimientoReportStatisticType.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Casos del Enum | 14-22 | Definición de todos los tipos de estadísticas |
| fullReport() | 26-34 | Retorna todos los tipos (6) |
| homeDashboard() | 37-41 | Retorna tipos para dashboard (2) |
| requiresComparativeData() | 49-56 | Determina si requiere período anterior |
| withComparativeData() | 63-70 | Retorna tipos que requieren comparación |

---

## Application Layer DTOs

### GenerateFinancialReportQuery.php
[app/Application/Reporte/DTOs/GenerateFinancialReportQuery.php](app/Application/Reporte/DTOs/GenerateFinancialReportQuery.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 14-24 | Definición de todas las propiedades públicas readonly |

---

## Application Layer Handlers

### GenerateReportHandler.php
[app/Application/Reporte/Handlers/GenerateReportHandler.php](app/Application/Reporte/Handlers/GenerateReportHandler.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 22-27 | Inyección de mapper y contribuidores |
| handle() | 35-50 | Genera reporte con tipos específicos |
| handle() - Mapeo | 36-37 | Mapea DTO a ReporteQuery |
| handle() - Iteración | 39-47 | Itera sobre contribuidores y filtra por tipo |
| fullReport() | 56-67 | Genera reporte completo de todos los contribuidores |

---

### MovimientoReportGenerationContributor.php
[app/Application/Reporte/Contributors/MovimientoReportGenerationContributor.php](app/Application/Reporte/Contributors/MovimientoReportGenerationContributor.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 26-29 | Inyección de MovimientoReportQueryOrchestrator |
| handle() | 39-54 | Genera estadísticas y consulta período anterior si aplica |
| handle() - Período Anterior | 45-53 | Lógica de reutilización de DTO anterior |
| contribute() | 62-66 | Contribución completa del dominio |
| shouldContribute() | 74-79 | Valida si contiene tipos MovimientoReportStatisticType |

---

## Application Layer Mappers

### ReportQueryMapper.php
[app/Application/Reporte/Mappers/ReportQueryMapper.php](app/Application/Reporte/Mappers/ReportQueryMapper.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 26-31 | Inyección de dependencias (resolver, specs) |
| map() | 38-48 | Mapea DTO a ReporteQuery |
| map() - Flujo | 40-47 | Resuelve fechas, granularidad, IDs |
| resolveDateRange() | 55-61 | Resuelve rango con default de 6 meses |
| resolveIds() | 69-73 | Convierte arrays a IdsDTO |

---

## Application Layer Orchestrators

### MovimientoReportQueryOrchestrator.php
[app/Application/Reporte/Orchestrators/MovimientoReportQueryOrchestrator.php](app/Application/Reporte/Orchestrators/MovimientoReportQueryOrchestrator.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 13-16 | Inyección de handlers |
| get() | 18-27 | Obtiene un tipo específico buscando handler |
| get() - Búsqueda | 19-24 | Itera handlers hasta encontrar que soporta tipo |
| get() - Error | 25-26 | Lanza excepción si no encuentra |
| getMultiple() | 28-37 | Ejecuta múltiples queries y combina resultados |

---

## Application Layer Assemblers

### KPIAssembler.php
[app/Application/Reporte/Assemblers/Movimientos/KPIAssembler.php](app/Application/Reporte/Assemblers/Movimientos/KPIAssembler.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Propiedades | 20-22 | staticType y PercentageService |
| Constructor | 24-27 | Inyección de PercentageService |
| instanceof() | 29-32 | Valida que sea MovimientoReportStatisticType |
| buildAssemble() | 34-53 | Construye PeriodKPIDTO con cálculos de variaciones |
| buildAssemble() - Cálculos | 44-52 | Usa PercentageService para calcular variaciones |

---

### ReportAssembler.php (Abstract)
[app/Application/Reporte/Assemblers/Abstracts/ReportAssembler.php](app/Application/Reporte/Assemblers/Abstracts/ReportAssembler.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Propiedades | 14-20 | Definición de statisticType protegido |
| supports() | 21-25 | Valida instanceof y igualdad de tipo |
| assemble() | 26-33 | Ejecuta ensamblaje si existe resultado |
| assemble() - Validación | 28-30 | Retorna null si no existe resultado |
| Métodos Abstractos | 40-53 | instanceof() y buildAssemble() |

---

## Application Layer Resolvers

### AssemblerResolver.php
[app/Application/Reporte/Resolvers/AssemblerResolver.php](app/Application/Reporte/Resolvers/AssemblerResolver.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 12-13 | Inyección de assemblers |
| resolve() | 21-36 | Busca y ejecuta assembler para tipo |
| resolve() - Búsqueda | 22-26 | Itera assemblers hasta encontrar que soporta |
| resolve() - Error | 28-31 | Lanza excepción si no encuentra |
| has() | 38-47 | Verifica existencia de assembler |

---

## Infrastructure Layer Query Handlers

### EloquentKPIsQueryExecutor.php
[app/Infrastructure/Reporte/Queries/Handlers/Movimientos/Eloquent/EloquentKPIsQueryExecutor.php](app/Infrastructure/Reporte/Queries/Handlers/Movimientos/Eloquent/EloquentKPIsQueryExecutor.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 32-34 | Inyección de MovimientoQueryRelationResolver |
| supports() | 36-39 | Valida que sea exactamente KPIS |
| handle() | 41-56 | Ejecuta query Eloquent con agrupación |
| handle() - SELECT | 43-49 | Construye SELECT con sumas condicionales y COUNT |
| handle() - WHERE | 51-52 | Aplica filtros de fecha |
| handle() - Relaciones | 53 | Resuelve relaciones necesarias |
| handle() - GROUP BY | 54 | Agrupa por granularidad temporal |

---

## HTTP Layer Controllers

### ReporteApiController.php
[app/Http/Controllers/Api/Reporte/ReporteApiController.php](app/Http/Controllers/Api/Reporte/ReporteApiController.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 22-25 | Inyección de GenerateReportHandler |
| index() | 32-37 | GET /api/reportes - reporte con defaults |
| index() - Llamada | 34-35 | Llama handler sin filtros |
| generate() | 47-52 | POST /api/reportes/generate - con filtros |
| generate() - Validación | 47-48 | Valida request |
| generate() - Mapeo | 49-50 | Convierte a GenerateFinancialReportQuery |

---

## HTTP Layer Requests

### GenerateReporteRequest.php
[app/Http/Requests/Reporte/GenerateReporteRequest.php](app/Http/Requests/Reporte/GenerateReporteRequest.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| authorize() | 16-19 | Autorización (siempre true) |
| rules() | 27-34 | Reglas de validación |
| rules() - Fechas | 28-29 | startDate y endDate requeridos como dates |
| rules() - Arrays | 30-31 | categorias y cuentas opcionales como arrays |
| rules() - Flag | 32 | only_categorias_fijas requerido como boolean |

---

## HTTP Layer Resources

### ReporteResource.php
[app/Http/Resources/Reporte/ReporteResource.php](app/Http/Resources/Reporte/ReporteResource.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| Constructor | 23-28 | Inyección de AssemblerResolver |
| toArray() | 36-67 | Estructura respuesta JSON |
| toArray() - KPIs | 38-42 | Ensambla KPIS |
| toArray() - Tendencia | 43-52 | Estructura tendencia con 3 secciones |
| toArray() - Distribuciones | 53-57 | Estructura distribuciones por categoría |
| assembleIfPresent() | 59-67 | Retorna null si tipo no existe |

---

## Shared Services

### PercentageService.php
[app/Shared/Domain/Services/Financial/PercentageService.php](app/Shared/Domain/Services/Financial/PercentageService.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| calculatePercentageChange() | 20-26 | Calcula porcentaje de cambio |
| calculatePercentageChange() - Lógica | 21-23 | ((current - previous) / \|previous\|) * 100 |
| calculatePercentageChange() - Validación | 21 | Retorna null si previous = 0 |
| calculatePercentage() | 34-40 | Calcula porcentaje simple |
| calculatePercentage() - Validación | 35-37 | Retorna 0 si divider = 0 |

---

## Application Layer Enums

### ReportStatisticType.php
[app/Application/Reporte/Enums/Statistics/ReportStatisticType.php](app/Application/Reporte/Enums/Statistics/ReportStatisticType.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| statistics() | 22-34 | Retorna todos los tipos para la UI (6) |
| statistics() - Movimientos | 24-27 | 5 tipos de Movimientos |
| statistics() - Presupuestos | 28 | 1 tipo de Presupuestos (USED_BUDGET) |

---

## Contratos e Interfaces

### ReportContributorContract.php
[app/Application/Reporte/Contracts/ReportContributorContract.php](app/Application/Reporte/Contracts/ReportContributorContract.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| handle() | 20-26 | Genera resultados para tipos específicos |
| contribute() | 33-39 | Contribución completa del dominio |
| shouldContribute() | 47-51 | Determina si debe ejecutarse |

---

### AssemblerContract.php
[app/Application/Reporte/Contracts/AssemblerContract.php](app/Application/Reporte/Contracts/AssemblerContract.php)

| Sección | Líneas | Descripción |
|---------|--------|-------------|
| supports() | 19-24 | Determina si soporta el tipo |
| assemble() | 31-37 | Realiza el ensamblaje |

---

## Rutas

### api.php
[routes/api.php](routes/api.php)

| Ruta | Línea | Controlador | Método | Nombre |
|------|-------|------------|--------|--------|
| GET /api/reportes | 14 | ReporteApiController | index | api.reportes.index |
| POST /api/reportes/generate | 15 | ReporteApiController | generate | api.reportes.generate |

---

## Patrones de Búsqueda Útiles

### Buscar todas las implementaciones de un contrato
```
grep -r "implements ReportContributorContract" app/
grep -r "implements AssemblerContract" app/
```

### Buscar uso de PercentageService
```
grep -r "PercentageService" app/
```

### Buscar uso de ReporteQueryResult
```
grep -r "ReporteQueryResult" app/
```

### Buscar handlers de queries
```
find app/Infrastructure/Reporte/Queries/Handlers -name "*Handler.php"
```

### Buscar assemblers
```
find app/Application/Reporte/Assemblers -name "*Assembler.php"
```

---

## Checklist de Modificaciones Comunes

### Agregar nuevo tipo de estadística
- [ ] Agregar case a `MovimientoReportStatisticType` enum
- [ ] Crear handler en `Infrastructure/Reporte/Queries/Handlers`
- [ ] Registrar handler en Service Provider
- [ ] Crear assembler si requiere transformación
- [ ] Registrar assembler en Service Provider
- [ ] Actualizar `ReportStatisticType::statistics()` si es para UI
- [ ] Actualizar `ReporteResource::toArray()` si requiere mostrar

### Cambiar cálculo de variaciones
- [ ] Modificar `PercentageService::calculatePercentageChange()`
- [ ] O crear nuevo método en servicio
- [ ] Actualizar `KPIAssembler` para usar nuevo método

### Agregar nuevo filtro
- [ ] Agregar propiedad a `GenerateFinancialReportQuery`
- [ ] Agregar validación en `GenerateReporteRequest::rules()`
- [ ] Agregar propiedad a `ReporteQuery`
- [ ] Actualizar `ReportQueryMapper::map()`
- [ ] Aplicar filtro en query handler

### Cambiar estructura JSON de respuesta
- [ ] Actualizar `ReporteResource::toArray()`
- [ ] Actualizar tests relacionados
- [ ] Documentar cambio en API

---

## Referencias Cruzadas

### Clases que usan DateRange
- ReporteQuery (ValueObject)
- ReportQueryMapper (Mapper)
- MovimientoReportGenerationContributor (Contributor)
- Tests (DateRangeTest)

### Clases que usan ReporteQueryResult
- GenerateReportHandler (Handler)
- MovimientoReportGenerationContributor (Contributor)
- MovimientoReportQueryOrchestrator (Orchestrator)
- KPIAssembler (Assembler)
- ReporteResource (Resource)

### Clases que usan PercentageService
- KPIAssembler (Assembler)
- Tests (KPIAssemblerTest)

### Clases que dependen de AssemblerResolver
- ReporteResource (Resource)
- Controllers (HTTP)

---

## Notas de Depuración

### Para debuggear una query de KPIs
1. Breakpoint en `EloquentKPIsQueryExecutor::handle()`
2. Verificar `$query->toSql()` para ver SQL final
3. Ejecutar SQL directamente en BD para validar

### Para debuggear assembly de DTOs
1. Breakpoint en `KPIAssembler::buildAssemble()`
2. Verificar que `$currentResults` contiene datos
3. Verificar que `$previousResults` contiene datos si aplica
4. Verificar cálculos de PercentageService

### Para debuggear flujo completo
1. Breakpoint en `ReporteApiController::generate()`
2. Verificar que `GenerateReporteRequest` validó correctamente
3. Breakpoint en `GenerateReportHandler::handle()`
4. Verificar que contribuidores se ejecutan
5. Breakpoint en `ReporteResource::toArray()`
6. Verificar estructura final antes de serializar
