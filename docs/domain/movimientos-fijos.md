# Dominio: MovimientoFijo

## Propósito del Módulo

El módulo `MovimientoFijo` representa una **plantilla de movimiento recurrente**: un ingreso o gasto que se repite periódicamente según una frecuencia configurada (diaria, semanal, mensual, etc.).

No es un movimiento en sí mismo; es una instrucción que el scheduler del sistema procesa diariamente para:
1. Generar un `MovimientoPendiente` (y opcionalmente registrar automáticamente el movimiento).
2. Enviar notificaciones de aviso con antelación configurada.

---

## Agregado Raíz: `MovimientoFijo`

**Namespace:** `App\Domains\MovimientoFijo\Aggregates\MovimientoFijo`

```php
final readonly class MovimientoFijo implements AggregateModelContract
{
    private function __construct(
        private MovimientoFijoId         $id,
        private CategoriaId              $categoria_id,
        private CuentaId                 $cuenta_id,
        private TipoMovimientoEnum       $tipo_movimiento_id,
        private FrecuenciaMovimientoEnum $frecuencia_movimiento_id,
        private string                   $nombre,
        private Amount                   $monto,
        private Date                     $fecha_proximo,
        private ?int                     $dias_aviso,
        private ?string                  $descripcion,
        private bool                     $active,
        private bool                     $registrar_automatico,
    ) {}
}
```

### Métodos de Fábrica

| Método | Propósito | Nota clave |
|--------|-----------|------------|
| `create(...)` | Crea la plantilla | `active=true`, `registrar_automatico=false` por defecto |
| `reconstitute(...)` | Rehidrata desde persistencia | Sin validaciones |
| `updateData(...)` | Actualiza los campos editables | Preserva `active` y `registrar_automatico` |
| `recalculateNextDate(resolver)` | Calcula la próxima fecha de ocurrencia | Usa `RecalculateNextDateResolver` |

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `MovimientoFijoId` | UUID v7 |
| Frecuencia | `FrecuenciaMovimientoEnum` | Enum: DIARIO..ANUAL |
| Monto | `Amount` | Valor positivo en centavos |
| Fecha próximo | `Date` | Próxima fecha de procesamiento |

---

## Enum: `FrecuenciaMovimientoEnum`

```php
enum FrecuenciaMovimientoEnum: int
{
    CASE DIARIO     = 1;
    CASE SEMANAL    = 2;
    CASE QUINCENAL  = 3;
    CASE MENSUAL    = 4;
    CASE BIMESTRAL  = 5;
    CASE TRIMESTRAL = 6;
    CASE SEMESTRAL  = 7;
    CASE ANUAL      = 8;
}
```

---

## Reglas de Negocio (Invariantes)

1. **Nombre obligatorio**: no puede ser vacío.
2. **Monto mayor a cero**: `$monto->isLessOrEqualThanCero()` lanza excepción.
3. **Tipo de movimiento obligatorio**: `$tipo_movimiento_id->value <= 0` no permitido.
4. **Frecuencia obligatoria**: `$frecuencia_movimiento_id <= 0` no permitido.
5. **Días de aviso no negativos**: si se proveen, deben ser ≥ 0.
6. **Al crear**: `registrar_automatico = false` siempre. Solo puede activarse posteriormente mediante toggle.

---

## Métodos de Comportamiento

### `isWarningDay(): bool`
Retorna `true` si hoy es el día de aviso (fecha_proximo − dias_aviso = hoy). Usado por el scheduler para enviar notificaciones de alerta anticipada.

```php
public function isWarningDay(): bool
{
    if ($this->dias_aviso === null || $this->dias_aviso <= 0) return false;
    $fecha_aviso = $this->fecha_proximo->getPeriod()
        ->sub(new DateInterval('P' . $this->dias_aviso . 'D'));
    return (new DateTimeImmutable())->format('Y-m-d') === $fecha_aviso->format('Y-m-d');
}
```

### `isDueToday(): bool`
Retorna `true` si hoy es el día de `fecha_proximo`. El scheduler procesa los movimientos fijos con `isDueToday() === true`.

### `recalculateNextDate(RecalculateNextDateResolver $resolver): self`
Usa el `RecalculateNextDateResolver` para calcular la nueva `fecha_proximo` según la frecuencia, retornando una nueva instancia inmutable.

---

## Patrón Strategy: Recalcular Fecha Próxima

El cálculo de la siguiente fecha según la frecuencia usa el patrón Strategy:

| Estrategia | Frecuencia |
|-----------|-----------|
| `DailyRecalculateForNextDateStrategy` | DIARIO |
| `WeeklyRecalculateForNextDateStrategy` | SEMANAL |
| `BiWeeklyRecalculateForNextDateStrategy` | QUINCENAL |
| `MonthlyRecalculateForNextDateStrategy` | MENSUAL |
| `BiMonthlyRecalculateForNextDateStrategy` | BIMESTRAL |
| `QuarterlyRecalculateForNextDateStrategy` | TRIMESTRAL |
| `SemiannualRecalculateForNextDateStrategy` | SEMESTRAL |
| `AnnualRecalculateForNextDateStrategy` | ANUAL |

El `RecalculateNextDateResolver` selecciona la estrategia correcta en función de `FrecuenciaMovimientoEnum`.

---

## Flujo de Procesamiento Diario

![Flujo](./../movimiento-fijo_scheduler_flow_diagram.svg)

---

## Esquema de Base de Datos

Tabla: `movimiento_fijos`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Nombre descriptivo |
| `descripcion` | text | Sí | Notas opcionales |
| `tipo_movimiento_id` | int (FK → tipo_movimientos) | No | INGRESO o GASTO |
| `categoria_id` | UUID (FK → categorias) | No | Clasificación |
| `cuenta_id` | UUID (FK → cuentas) | No | Cuenta afectada |
| `frecuencia_movimiento_id` | int (FK → frecuencia_movimientos) | No | Periodicidad |
| `monto` | decimal(18,2) | No | Monto del movimiento |
| `fecha_proximo` | date | No | Próxima fecha de ejecución |
| `dias_aviso` | tinyint unsigned | Sí | Días de aviso previo |
| `active` | boolean | No | Activo/inactivo |
| `registrar_automatico` | boolean | No | Registro automático |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índice:** `movimiento_fijo_index`: `(tipo_movimiento_id, categoria_id, cuenta_id, frecuencia_movimiento_id)`
