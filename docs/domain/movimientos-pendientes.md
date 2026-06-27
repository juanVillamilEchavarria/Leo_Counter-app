# Dominio: MovimientoPendiente

## Propósito del Módulo

El módulo `MovimientoPendiente` representa un movimiento financiero **planificado para el futuro** que aún no se ha ejecutado. Puede ser creado manualmente por el usuario o generado automáticamente por el sistema cuando un `MovimientoFijo` llega a su fecha de vencimiento.

El movimiento pendiente tiene un ciclo de vida con tres estados posibles: `PENDIENTE`, `REALIZADO` y `VENCIDO`.

---

## Agregado Raíz: `MovimientoPendiente`

**Namespace:** `App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente`

```php
final readonly class MovimientoPendiente implements PrimitiveAggregateModelContract
{
    private function __construct(
        private MovimientoPendienteId      $id,
        private CategoriaId                $categoria_id,
        private CuentaId                   $cuenta_id,
        private ?MovimientoFijoId          $movimiento_fijo_id,  // null si es manual
        private TipoMovimientoEnum         $tipo_movimiento_id,
        private string                     $nombre,
        private Amount                     $monto,
        private Date                       $fecha_programada,
        private ?int                       $dias_aviso,
        private ?string                    $descripcion,
        private EstadosMovimientoPendiente $estado,
    ) {}
}
```

---

## Enum: `EstadosMovimientoPendiente`

```php
enum EstadosMovimientoPendiente: string
{
    case PENDIENTE = 'pendiente';
    case REALIZADO = 'realizado';
    case VENCIDO   = 'vencido';
}
```

---

## Métodos de Fábrica y Comportamiento

| Método | Propósito | Estado resultado |
|--------|-----------|-----------------|
| `create(...)` | Crea el pendiente (manual o automático) | `PENDIENTE` por defecto |
| `reconstitute(...)` | Rehidrata desde persistencia | Estado persistido |
| `updateData(...)` | Actualiza campos editables | Preserva estado |
| `markAsDone()` | Transiciona a REALIZADO | `REALIZADO` |
| `markAsExpired()` | Transiciona a VENCIDO | `VENCIDO` |

### `markAsDone()`
```php
public function markAsDone(): self
{
    return new self(
        // ... todos los campos actuales ...
        estado: EstadosMovimientoPendiente::REALIZADO,
    );
}
```

### `markAsExpired()`
```php
public function markAsExpired(): self
{
    return new self(
        // ... todos los campos actuales ...
        estado: EstadosMovimientoPendiente::VENCIDO,
    );
}
```

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `MovimientoPendienteId` | UUID v7 |
| Categoría | `CategoriaId` | Clasificación del movimiento |
| Cuenta | `CuentaId` | Cuenta donde se registrará |
| Fijo origen | `MovimientoFijoId?` | `null` si fue creado manualmente |
| Tipo | `TipoMovimientoEnum` | INGRESO o GASTO |
| Monto | `Amount` | Valor positivo |
| Fecha | `Date` | Fecha programada |
| Estado | `EstadosMovimientoPendiente` | Ciclo de vida |

---

## Reglas de Negocio (Invariantes)

1. **Nombre obligatorio**: vacío lanza `CannotStoreMovimientoPendienteException`.
2. **Monto mayor a cero**: obligatorio.
3. **Tipo de movimiento obligatorio**: `tipo_movimiento_id.value > 0`.
4. **Días de aviso no negativos**: si se proveen.
5. **Estado inicial `PENDIENTE`** si no se especifica en `create()`.
6. **Un movimiento pendiente asociado a un `MovimientoFijo`** tiene `movimiento_fijo_id` no nulo.
7. **La transición a `REALIZADO`** solo se hace mediante `markAsDone()`. El sistema luego crea el `Movimiento` real.
8. **La transición a `VENCIDO`** ocurre automáticamente si `wasExpiredYesterday() === true`. El sistema luego **elimina el registro permanentemente** y envia una notifcacion de la accion

---

## Métodos de Estado

### `isWarningDay(): bool`
Retorna `true` si hoy es el día de aviso configurado (misma lógica que `MovimientoFijo`).

### `wasExpiredYesterday(): bool`
```php
public function wasExpiredYesterday(): bool
{
    $yesterday = (new DateTimeImmutable())->sub(new DateInterval('P1D'));
    return $yesterday->format('Y-m-d') === $this->fecha_programada->getPeriod()->format('Y-m-d');
}
```
El scheduler lo usa para marcar movimientos como `VENCIDO` al día siguiente de su fecha programada.

---

## Flujo: Marcar como Realizado

![Flujo](./../mark_as_done_movimiento-pendiente.svg)


---

## Esquema de Base de Datos

Tabla: `movimiento_pendientes`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Nombre descriptivo |
| `categoria_id` | UUID (FK → categorias) | No | Clasificación |
| `cuenta_id` | UUID (FK → cuentas) | No | Cuenta objetivo |
| `movimiento_fijo_id` | UUID (FK → movimiento_fijos) | Sí | Fijo generador |
| `tipo_movimiento_id` | int (FK → tipo_movimientos) | No | INGRESO o GASTO |
| `monto` | decimal(18,2) | No | Valor planificado |
| `fecha_programada` | date | No | Cuándo se realizará |
| `estado` | enum('pendiente','realizado','vencido') | No | Estado del ciclo de vida |
| `dias_aviso` | tinyint unsigned | Sí | Días de aviso (default 0) |
| `descripcion` | text | Sí | Notas opcionales |
| `paid_at` | timestamp | Sí | Cuándo fue realizado |
| `deleted_at` | timestamp | Sí | Soft delete |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índices:**
- `(estado, fecha_programada)`
- `(movimiento_fijo_id)`
- `movimiento_pendiente_index`: `(categoria_id, cuenta_id, tipo_movimiento_id)`
