# Dominio: Cuenta

## Propósito del Módulo

El módulo `Cuenta` representa una cuenta financiera real del usuario (cuenta bancaria, billetera digital, efectivo en mano, etc.). Es el contenedor donde fluye el dinero: los Movimientos e Ingresos la afectan, y las Transferencias redistribuyen el dinero entre cuentas.

El saldo de una Cuenta **nunca se calcula sumando transacciones**; es un campo actualizado de forma incremental mediante eventos de dominio (`MovimientoCreated`, `MovimientoDeleted`, `TransferenciaCreated`).

---

## Agregado Raíz: `Cuenta`

**Namespace:** `App\Domains\Cuenta\Aggregates\Cuenta`

```php
final readonly class Cuenta implements AggregateModelContract
{
    private function __construct(
        private CuentaId      $id,
        private string        $nombre,
        private ?string       $notas,
        private Amount        $saldo_inicial,
        private Amount        $saldo_actual,
        private bool          $active,
        private PropietarioId $propietario_id,
        private int           $tipo_cuenta_id,
    ) {}
}
```

### Métodos de Fábrica

| Método | Propósito | Nota clave |
|--------|-----------|------------|
| `create(...)` | Crea una cuenta nueva | `saldo_actual` = `saldo_inicial` al crear |
| `reconstitute(...)` | Rehidrata desde persistencia | Sin validaciones |
| `updateData(...)` | Actualiza datos editables | Usa `CuentaCanUpdateSaldoInicialCheckerContract` |
| `updateSaldoActual(...)` | Actualiza solo el saldo actual | Llamado por EventHandlers financieros |

### Invariante de Actualización de Saldo Inicial

```php
public function updateData(
    string     $nombre,
    ?string    $notas,
    Amount     $saldo_inicial,
    Amount     $saldo_actual,
    PropietarioId $propietario_id,
    int        $tipo_cuenta_id,
    CuentaId   $id,
    CuentaCanUpdateSaldoInicialCheckerContract $checker,
): self {
    // Si la cuenta no tiene movimientos, actualizar saldo_actual = saldo_inicial
    if ($checker->canUpdateSaldoInicial($id)) {
        $saldo_actual = $saldo_inicial;
    }
    self::validateData($nombre, CannotUpdateCuentaException::class);
    return new self(...);
}
```

La lógica de si una cuenta puede actualizar su `saldo_inicial` (sin movimientos ni transferencias) está encapsulada en el contrato `CuentaCanUpdateSaldoInicialCheckerContract`, cuya implementación vive en Infraestructura.

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `CuentaId` (extiende `DomainId`) | UUID v7 |
| Propietario | `PropietarioId` | Referencia al dueño |
| Saldo Inicial | `Amount` | Monto de apertura |
| Saldo Actual | `Amount` | Saldo vigente (actualizado por eventos) |

---

## Reglas de Negocio (Invariantes)

1. **El nombre es obligatorio**: `trim($nombre) === ''` lanza `CannotStoreCuentaException` o `CannotUpdateCuentaException`.
2. **Al crear, `saldo_actual` = `saldo_inicial`**: No se puede crear una cuenta con saldo actual diferente al inicial.
3. **El `saldo_actual` solo puede cambiar** mediante `updateSaldoActual()`, invocado por los EventHandlers financieros.
4. **El `saldo_inicial` solo se puede modificar** si la cuenta no tiene movimientos o transferencias registradas (checker de dominio).
5. **La eliminación de una cuenta relacionada a movimientos o transferencias  está bloqueada** por `CannotDeleteCuentaException`.
6. **Una cuenta puede activarse/desactivarse** (campo `active`) mediante la ruta `PATCH /cuentas/{cuenta}/{attribute}/toggle`.

---

## Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `CuentaRepositoryContract` | CRUD del agregado |
| `CuentaCanUpdateSaldoInicialCheckerContract` | Verifica si la cuenta puede actualizar su saldo inicial |

---

## Esquema de Base de Datos

Tabla: `cuentas`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Nombre descriptivo |
| `saldo_inicial` | decimal(18,2) | No | Saldo de apertura |
| `saldo_actual` | decimal(18,2) | No | Saldo vigente (default 0) |
| `tipo_cuenta_id` | int (FK → tipo_cuentas) | No | Tipo de cuenta |
| `propietario_id` | UUID (FK → propietarios) | Sí | Dueño (nullable) |
| `notas` | text | Sí | Notas adicionales |
| `active` | boolean | No | Estado activo/inactivo |
| `deleted_at` | timestamp | Sí | Soft delete |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índices:** `tipo_cuenta_id`, `propietario_id`, `active`

---

## Flujo de Actualización de Saldo
#### Desde movimientos
![Flujo](./../movimiento_update_saldo_cuenta_flow_diagram.svg)

#### Desde Transferencia
![Flujo](./../transferencia_update_saldo_cuenta_flow_diagram.svg)

