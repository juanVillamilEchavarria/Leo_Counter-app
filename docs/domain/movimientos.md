# Dominio: Movimiento

## Propósito del Módulo

El módulo `Movimiento` representa el **hecho contable central** del sistema: un flujo de dinero ya realizado (ingreso o gasto). Es el agregado raíz más importante de Leo Counter. Todo movimiento impacta directamente el saldo de una `Cuenta` mediante eventos de dominio.

La UI divide los movimientos en dos vistas:
- **Históricos**: Solo lectura. Listado de todos los movimientos registrados.
- **Espontáneos**: CRUD completo. Movimientos creados manualmente en el momento.

Ambas vistas operan sobre la misma tabla `movimientos`.

---

## Agregado Raíz: `Movimiento`

**Namespace:** `App\Domains\Movimiento\Aggregates\Movimiento`

```php
final class Movimiento implements PrimitiveAggregateModelContract
{
    use RecordsEvents;

    private function __construct(
        private MovimientoId           $id,
        private string                 $nombre,
        private CuentaId               $cuenta_id,
        private CategoriaId            $categoria_id,
        private TipoMovimientoEnum     $tipo_movimiento_id,
        private ?MovimientoPendienteId $movimiento_pendiente_id,
        private Amount                 $monto,
        private Date                   $fecha,
        private ?string                $descripcion,
    ) {}
}
```

### Métodos de Fábrica

| Método | Propósito | Dispara evento |
|--------|-----------|----------------|
| `create(...)` | Crea un nuevo movimiento validando invariantes | ✅ `MovimientoCreated` |
| `reconstitute(...)` | Rehidrata desde persistencia | ❌ |
| `updateData(...)` | Actualiza los datos del movimiento | ❌ |
| `delete()` | Retorna una copia con evento de eliminación grabado | ✅ `MovimientoDeleted` |

### Implementación de `create()`

```php
public static function create(
    MovimientoId           $id,
    string                 $nombre,
    CuentaId               $cuenta_id,
    CategoriaId            $categoria_id,
    TipoMovimientoEnum     $tipo_movimiento_id,
    Amount                 $monto,
    Date                   $fecha,
    ?string                $descripcion = null,
    ?MovimientoPendienteId $movimiento_pendiente_id = null,
): self
{
    self::validateData($nombre, $monto, CannotExecuteMovimientoTransactionException::class);
    $movimiento = new self(...);
    $movimiento->recordThat(new MovimientoCreated($movimiento));
    return $movimiento;
}
```

### Implementación de `delete()`

```php
public function delete(): self
{
    $copy = new self(...); // Copia inmutable del estado actual
    $copy->recordThat(new MovimientoDeleted($copy));
    return $copy;
}
```

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `MovimientoId` (extiende `DomainId`) | UUID v7 generado por `IdGeneratorContract` |
| Cuenta | `CuentaId` | Referencia a la cuenta afectada |
| Categoría | `CategoriaId` | Referencia a la categoría clasificadora |
| Tipo | `TipoMovimientoEnum` | `INGRESO (1)` o `GASTO (2)` |
| Monto | `Amount` | Valor monetario positivo, almacenado en centavos |
| Fecha | `Date` | Envuelve `DateTimeImmutable` |
| Pendiente | `MovimientoPendienteId?` | Referencia opcional al pendiente de origen |

---

## Eventos de Dominio

### `MovimientoCreated`
- **Namespace:** `App\Domains\Movimiento\Events\MovimientoCreated`
- **Disparado en:** `Movimiento::create()`
- **Listener:** `MovimientoCreatedFinancialImpactEventHandler`
- **Efecto:** Aplica el impacto financiero en la `Cuenta`:
  - `INGRESO` → incrementa `saldo_actual`
  - `GASTO` → reduce `saldo_actual` (con validación de fondos suficientes para gastos)

### `MovimientoDeleted`
- **Namespace:** `App\Domains\Movimiento\Events\MovimientoDeleted`
- **Disparado en:** `Movimiento::delete()`
- **Listener:** `MovimientoDeletedFinancialImpactEventHandler`
- **Efecto:** Revierte el impacto financiero original en la `Cuenta`

---

## Reglas de Negocio (Invariantes)

1. **El nombre es obligatorio:** `trim($nombre) === ''` lanza `CannotExecuteMovimientoTransactionException`.
2. **El monto debe ser mayor a cero:** `$monto->isLessOrEqualThanCero()` lanza excepción.
3. **La fecha se asigna en el momento del registro**, no es editable por el usuario (se toma `new DateTimeImmutable()` en el Handler).
4. **La eliminación es lógica (soft delete):** La tabla `movimientos` tiene columna `deleted_at`.
5. **Los comprobantes adjuntos** se eliminan del storage al eliminar el movimiento, mediante el evento de aplicación `AttachmentsForMovimientoDeleted`.

---

## Flujo de Registro de un Movimiento Espontáneo


![Flujo](./../create_movimientos_client_flow_diagram.svg)



---

## Estrategias de Transacción

El módulo Movimiento usa el patrón Strategy para aplicar y revertir efectos financieros:

### Apply (al crear)
- `ApplyIngresoEffectForCuentaForCuentaStrategy`: incrementa `saldo_actual`.
- `ApplyGastoEffectForCuentaStrategy`: reduce `saldo_actual`.

### Revert (al eliminar)
- `RevertIngresoEffectForCuentaWhenMovimientoIsChanged`: deshace el incremento.
- `RevertGastoEffectForCuentaWhenMovimientoIsChangedStrategy`: deshace la reducción.

### Validators
- `IngresoValidatorStrategy`: valida reglas de negocio específicas de ingresos.
- `GastoValidatorStrategy`: valida que la cuenta tiene fondos suficientes (si aplica).

---

## Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `MovimientoRepositoryContract` | CRUD de persistencia del agregado |
| `FinancialMovimientoRegisteredEventContract` | Contrato de los eventos financieros del movimiento |
| `DestroyAttachmentsForMovimientoEventContract` | Eliminar archivos adjuntos |
| `UploadAttachmentsForMovimientoEventContract` | Subir archivos adjuntos |
| `UpdateAttachmentsForMovimientoEventContract` | Actualizar archivos adjuntos |
| `ApplyTransactionEffectForCuentaStrategyContract` | Aplicar efecto financiero |
| `RevertTransactionEffectForCuentaStrategyContract` | Revertir efecto financiero |
| `TransactionValidatorStrategyContract` | Validar pre-condiciones de transacción |

---

## Esquema de Base de Datos

Tabla: `movimientos`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Nombre descriptivo del movimiento |
| `cuenta_id` | UUID (FK → cuentas) | No | Cuenta afectada |
| `categoria_id` | UUID (FK → categorias) | No | Categoría clasificadora |
| `tipo_movimiento_id` | int (FK → tipo_movimientos) | No | 1=INGRESO, 2=GASTO |
| `movimiento_pendiente_id` | UUID (FK → movimiento_pendientes) | Sí | Pendiente de origen |
| `monto` | decimal(18,2) | No | Valor del movimiento |
| `fecha` | date | No | Fecha de realización |
| `descripcion` | text | Sí | Notas adicionales |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índices:**
- `movimiento_index`: `(cuenta_id, categoria_id, tipo_movimiento_id)`
- `(fecha, categoria_id)`
- `(fecha, tipo_movimiento_id)`
- `(movimiento_pendiente_id)`
