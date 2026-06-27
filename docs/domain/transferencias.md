# Dominio: Transferencia

## Propósito del Módulo

El módulo `Transferencia` representa el movimiento de dinero **entre dos cuentas del sistema**. A diferencia de un `Movimiento`, una transferencia no entra ni sale del sistema: el dinero total permanece igual. Solo redistribuye el saldo entre una cuenta de origen y una de destino.

---

## Agregado Raíz: `Transferencia`

**Namespace:** `App\Domains\Transferencia\Aggregates\Transferencia`

```php
final class Transferencia implements AggregateModelContract
{
    use RecordsEvents;

    public function __construct(
        private TransferenciaId $id,
        private CuentaId        $cuenta_origen_id,
        private CuentaId        $cuenta_destino_id,
        private Amount          $monto,
        private Date            $fecha,
        private ?string         $descripcion
    ) {}
}
```

### Métodos de Fábrica

| Método | Propósito | Dispara evento |
|--------|-----------|----------------|
| `create(...)` | Crea y valida la transferencia | ✅ `TransferenciaCreated` |
| `reconstitute(...)` | Rehidrata desde persistencia | ❌ |

---

## Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `TransferenciaId` | UUID v7 |
| Cuenta origen | `CuentaId` | Cuenta que pierde saldo |
| Cuenta destino | `CuentaId` | Cuenta que gana saldo |
| Monto | `Amount` | Valor a transferir (positivo) |
| Fecha | `Date` | Fecha de la operación |

---

## Reglas de Negocio (Invariantes)

```php
private static function validateData(Amount $monto, Date $fecha, ?string $descripcion): void
{
    if ($monto->isLessOrEqualThanCero()) {
        throw new CannotCreateTransferenciaException('El monto debe ser mayor a cero.');
    }

    if ($fecha->getPeriod() > new DateTimeImmutable()) {
        throw new CannotCreateTransferenciaException('La fecha no puede ser futura.');
    }

    if ($descripcion !== null && strlen($descripcion) > 255) {
        throw new CannotCreateTransferenciaException('La descripción no puede exceder los 255 caracteres.');
    }
}
```

1. **Monto mayor a cero**: obligatorio.
2. **La fecha no puede ser futura**: una transferencia solo puede registrarse con fecha igual o anterior a hoy.
3. **Descripción máximo 255 caracteres** si se provee.
4. **No hay eliminación de transferencias**: el módulo solo soporta `index` y `store`. Las transferencias son inmutables.

---

## Evento de Dominio: `TransferenciaCreated`

- **Namespace:** `App\Domains\Transferencia\Events\TransferenciaCreated`
- **Disparado en:** `Transferencia::create()`
- **Listener:** `ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler`

**Efecto del EventHandler:**
1. Obtiene `cuenta_origen` → aplica estrategia de débito → actualiza `saldo_actual`.
2. Obtiene `cuenta_destino` → aplica estrategia de crédito → actualiza `saldo_actual`.

![Flujo](./../transferencia_update_saldo_cuenta_flow_diagram.svg)



---

## Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `TransferenciaRepositoryContract` | Persistencia del agregado |

---

## Esquema de Base de Datos

Tabla: `transferencias`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `cuenta_origen_id` | UUID (FK → cuentas) | No | Cuenta que pierde dinero |
| `cuenta_destino_id` | UUID (FK → cuentas) | No | Cuenta que gana dinero |
| `monto` | decimal(18,2) | No | Monto transferido |
| `descripcion` | varchar(255) | Sí | Nota opcional |
| `fecha` | date | No | Fecha de la operación |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índice:** `(cuenta_origen_id, cuenta_destino_id)`

> **Nota:** La tabla `transferencias` no tiene `soft deletes`. Las transferencias son permanentes e inmutables una vez registradas.
