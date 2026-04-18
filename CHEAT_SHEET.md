# Cheat Sheet Visual - Sistema de Reportes

## 🚀 Inicio Rápido (2 minutos)

```
Quiero entender la arquitectura
    ↓
Lee: ARCHITECTURE_VISUAL_SUMMARY.md (20 min)

Quiero crear un test
    ↓
Lee: TESTING_EXAMPLES_AND_CHECKLIST.md (15 min)
Ejecuta: ./vendor/bin/pest (2 min)

Quiero encontrar una clase
    ↓
Busca en: QUICK_REFERENCE.md o FILE_MAP_AND_LINES.md (1 min)

Quiero debuggear algo
    ↓
Lee: FILE_MAP_AND_LINES.md sección "Debugging" (5 min)
```

---

## 📁 Estructura de Archivos (Vista Simple)

```
app/
├── Domains/Reporte/
│   ├── ValueObjects/
│   │   ├── DateRange.php              ← Encapsula rango de fechas
│   │   ├── ReporteQuery.php           ← Parámetros de consulta
│   │   └── ReporteQueryResult.php     ← Resultados inmutables
│   ├── Enums/Statistic/
│   │   └── MovimientoReportStatisticType.php  ← KPIS, BALANCE_NETO, etc
│   └── Contracts/
│       ├── ReportStatisticTypeContract
│       └── [otros]
│
├── Application/Reporte/
│   ├── Handlers/
│   │   └── GenerateReportHandler.php  ← PUNTO DE ENTRADA
│   ├── Contributors/
│   │   └── MovimientoReportGenerationContributor.php
│   ├── Orchestrators/
│   │   └── MovimientoReportQueryOrchestrator.php
│   ├── Assemblers/
│   │   └── Movimientos/KPIAssembler.php
│   ├── Mappers/
│   │   └── ReportQueryMapper.php
│   ├── Resolvers/
│   │   └── AssemblerResolver.php
│   └── DTOs/
│       └── GenerateFinancialReportQuery.php
│
├── Infrastructure/Reporte/
│   └── Queries/Handlers/Movimientos/Eloquent/
│       └── EloquentKPIsQueryExecutor.php
│
└── Http/
    ├── Controllers/Api/Reporte/
    │   └── ReporteApiController.php   ← CONTROLADOR API
    ├── Resources/Reporte/
    │   └── ReporteResource.php        ← SERIALIZADOR JSON
    └── Requests/Reporte/
        └── GenerateReporteRequest.php ← VALIDACIÓN
```

---

## 🔄 Flujo de Ejecución (Versión Ultra-Simplificada)

```
POST /api/reportes/generate
    ↓ ValidateRequest
GenerateFinancialReportQuery
    ↓ ReportHandler::handle()
GenerateReportHandler
    ├─ MapDTO → ReporteQuery
    ├─ Ejecutar Contribuidores
    │  └─ MovimientoReportGenerationContributor
    │     └─ Query DB → LaravelKPICollection
    └─ Retorna ReporteQueryResult
    ↓ ReporteResource::toArray()
ReporteResource
    ├─ Resuelve Assemblers
    ├─ KPIAssembler → PeriodKPIDTO
    └─ Retorna estructura JSON
    ↓
JSON RESPONSE
```

---

## 🧩 Componentes Clave (1 línea cada uno)

| Componente | Responsabilidad | Ubicación |
|-----------|-----------------|-----------|
| **DateRange** | Encapsula fechas de inicio/fin | Domain/ValueObjects |
| **ReporteQuery** | Parámetros de consulta (filtros) | Domain/ValueObjects |
| **ReporteQueryResult** | Almacena resultados (immutable) | Domain/ValueObjects |
| **MovimientoReportStatisticType** | Enum de tipos (KPIS, BALANCE_NETO, etc) | Domain/Enums |
| **GenerateReportHandler** | Orquestador principal (punto de entrada) | Application/Handlers |
| **MovimientoReportGenerationContributor** | Contribuye datos de movimientos | Application/Contributors |
| **MovimientoReportQueryOrchestrator** | Orquesta queries de movimientos | Application/Orchestrators |
| **KPIAssembler** | Transforma datos a PeriodKPIDTO | Application/Assemblers |
| **ReportQueryMapper** | Mapea DTO a Value Object | Application/Mappers |
| **AssemblerResolver** | Busca assembler correcto | Application/Resolvers |
| **EloquentKPIsQueryExecutor** | Ejecuta query SQL para KPIs | Infrastructure/Handlers |
| **ReporteApiController** | Controlador HTTP | Http/Controllers |
| **ReporteResource** | Serializador a JSON | Http/Resources |
| **GenerateReporteRequest** | Valida entrada HTTP | Http/Requests |
| **PercentageService** | Calcula porcentajes | Shared/Services |

---

## 🎯 Métodos Más Importantes

### DateRange
```php
new DateRange($start, $end)     // Constructor
$range->diffDays()              // Diferencia en días
$range->toPreviousPeriod()      // Período anterior
DateRange::lastSixMonths()      // Factory: últimos 6 meses
```

### ReporteQueryResult
```php
$result->add($type, $data)      // Agregar resultado
$result->get($type)             // Obtener resultado
$result->has($type)             // ¿Existe resultado?
$result->addPrevious($type, $data)  // Agregar período anterior
$result->getPrevious($type)     // Obtener período anterior
```

### GenerateReportHandler
```php
$handler->handle($types, $dto)  // Genera reporte para tipos
$handler->fullReport($dto)      // Genera reporte completo
```

### EloquentKPIsQueryExecutor
```php
$handler->handle($query)        // Ejecuta query de KPIs
$handler->supports($type)       // ¿Soporta este tipo?
```

### PercentageService
```php
$service->calculatePercentageChange($current, $previous)
$service->calculatePercentage($value, $divider)
```

---

## 📊 Enums y Sus Valores

### MovimientoReportStatisticType
```
KPIS = 'kpis'                           (requiere período anterior ⭐)
BALANCE_NETO = 'balance_neto'
INGRESOS_VS_GASTOS = 'ingresos_vs_gastos'
CATEGORY_DISTRIBUTION = 'category_distribution'
INGRESOS = 'ingresos'
GASTOS = 'gastos'
```

**Métodos útiles:**
- `fullReport()` → 6 tipos
- `homeDashboard()` → 2 tipos (KPIS, INGRESOS_VS_GASTOS)
- `requiresComparativeData()` → ¿Necesita período anterior?

---

## 🧪 Testing Rápido

### Estructura básica
```php
use PHPUnit\Framework\TestCase;

class DateRangeTest extends TestCase {
    public function test_something(): void {
        // Arrange
        $dateRange = new DateRange($start, $end);
        
        // Act
        $days = $dateRange->diffDays();
        
        // Assert
        $this->assertEquals(30, $days);
    }
}
```

### Ejecutar
```bash
./vendor/bin/pest                           # Todos
./vendor/bin/pest --filter="DateRange"      # Específico
./vendor/bin/pest tests/Unit                # Unitarios
./vendor/bin/pest --coverage                # Con cobertura
```

---

## 🔍 Búsqueda Rápida

| Necesito... | Busco en... | Tiempo |
|-----------|-----------|--------|
| Entender flujo general | ARCHITECTURE_VISUAL_SUMMARY.md | 20 min |
| Ubicar una clase | QUICK_REFERENCE.md o FILE_MAP_AND_LINES.md | 1 min |
| Ver método específico | QUICK_REFERENCE.md tabla | 2 min |
| Ejemplo de test | TESTING_EXAMPLES_AND_CHECKLIST.md | 5 min |
| Ejecutar test | TESTING_EXECUTION_GUIDE.md | 5 min |
| Debuggear problema | FILE_MAP_AND_LINES.md "Debugging" | 5 min |

---

## ⚡ Atajos Útiles

### Para Agregar Nueva Estadística
1. Agregar case a `MovimientoReportStatisticType` enum
2. Crear handler en `Infrastructure/Reporte/Queries/Handlers`
3. Crear assembler en `Application/Reporte/Assemblers`
4. Registrar en Service Provider

### Para Cambiar Cálculos
1. Modificar `PercentageService` en `Shared/Domain/Services/Financial`
2. O crear nuevo servicio
3. Inyectar en assembler

### Para Debuggear Query SQL
1. Breakpoint en `EloquentKPIsQueryExecutor::handle()`
2. Ejecutar: `dd($query->toSql())`
3. Copiar SQL y ejecutar en BD

---

## 💾 Inyección de Dependencias Rápida

```php
// En Service Provider (config/services.php o App/Providers/*)

// Handler necesita mapper y contribuidores
$container->singleton(GenerateReportHandler::class, function() {
    return new GenerateReportHandler(
        $container->make(ReportQueryMapper::class),
        $container->make('report.contributors')  // Array
    );
});

// Orchestrator necesita handlers
$container->singleton(MovimientoReportQueryOrchestrator::class, function() {
    return new MovimientoReportQueryOrchestrator(
        $container->make('report.handlers')  // Array
    );
});
```

---

## 🧪 Testing Checklist Mini

```
□ Tests unitarios para ValueObjects
□ Tests unitarios para Enums
□ Tests de integración para Handlers
□ Tests de integración para Assemblers
□ Tests de integración para Query Handlers
□ Tests E2E para Controllers
□ Cobertura >= 85%
□ No hay N+1 queries
```

---

## 📋 Validación (GenerateReporteRequest)

```php
'startDate'              => required, date
'endDate'                => required, date
'categorias'             => nullable, array
'cuentas'                => nullable, array
'only_categorias_fijas'  => required, boolean
```

---

## 🌐 Rutas HTTP

```
GET  /api/reportes                  → index (defauts)
POST /api/reportes/generate         → generate (con filtros)
```

---

## 🎁 Respuesta JSON (Estructura)

```json
{
  "data": {
    "KPIs": {
      "totales": {
        "ingresos": 1000,
        "gastos": 500,
        "balance_neto": 500,
        "movimientos": 10
      },
      "variaciones": {
        "ingresos": 25.0,      // porcentaje
        "gastos": 10.0,
        "balance_neto": 20.0,
        "movimientos": 5.0
      }
    },
    "tendencia": {
      "ingresos_vs_gastos": {...},
      "balance_neto_por_fecha": {...},
      "presupuesto": {...}
    },
    "distribuiciones": {
      "por_categoria": {...}
    }
  }
}
```

---

## ⚠️ Casos Especiales

### Período Anterior
- Solo KPIS requiere período anterior
- Se consulta una sola vez y se reutiliza
- Misma duración que período actual, termina día antes

### Variaciones Nulas
```php
// Si previous = 0 → retorna null
// Si divider = 0 → retorna 0
$variation = calculatePercentageChange(1000, 0);  // null
```

### Rango por Defecto
- Si no hay startDate/endDate → últimos 6 meses

---

## 🔗 Enlaces de Referencia

```
📄 INVESTIGATION_REPORT_CLASSES.md      ← Análisis detallado
⚡ QUICK_REFERENCE.md                   ← Búsqueda rápida
📊 ARCHITECTURE_VISUAL_SUMMARY.md       ← Diagramas
🗂️ FILE_MAP_AND_LINES.md                ← Ubicación de código
✅ TESTING_EXAMPLES_AND_CHECKLIST.md    ← Tests con ejemplos
🧪 TESTING_EXECUTION_GUIDE.md           ← Guía de ejecución
📑 INDEX_MASTER_DOCUMENTATION.md        ← Índice de todo
```

---

## 🎓 Recomendación: Primera Hora

1. **5 min:** Lee este Cheat Sheet (ahora mismo)
2. **15 min:** Lee ARCHITECTURE_VISUAL_SUMMARY.md sección 1-2
3. **10 min:** Abre QUICK_REFERENCE.md y explora
4. **10 min:** Ejecuta un test: `./vendor/bin/pest --filter="DateRange"`
5. **20 min:** Lee un ejemplo de test en TESTING_EXAMPLES_AND_CHECKLIST.md

**Total:** 60 minutos → Listo para crear tus propios tests

---

## 📞 SOS Rápido

**¿No entiendo nada?**
→ Lee ARCHITECTURE_VISUAL_SUMMARY.md, luego este Cheat Sheet

**¿Dónde está el método X?**
→ Busca en QUICK_REFERENCE.md

**¿Cuál es el número de línea?**
→ Busca en FILE_MAP_AND_LINES.md

**¿Cómo escribo un test?**
→ Ve TESTING_EXAMPLES_AND_CHECKLIST.md

**¿Cómo lo ejecuto?**
→ Ve TESTING_EXECUTION_GUIDE.md

---

**¡Ahora sí, estás listo!** 🚀

Última actualización: 17 de abril de 2026
