# Dominio: Auditoría

## Propósito del Módulo

El módulo `Auditoria` registra automáticamente **todos los cambios críticos** realizados sobre los módulos auditables del sistema: `Movimientos`, `MovimientosPendientes` y `Presupuestos`. Es de solo lectura para el usuario; el sistema lo alimenta de forma transparente mediante el evento `AuditableActionOcurred`.

---

## Módulos Auditables

```php
enum AuditableTypes: string
{
    CASE MOVIMIENTOS           = 'movimientos';
    CASE MOVIMIENTOS_PENDIENTES = 'movimientos_pendientes';
    CASE PRESUPUESTOS          = 'presupuestos';
}
```

---

## Acciones Auditadas

```php
enum AuditableActions: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
```

---

## Agregado: `Auditoria`

**Namespace:** `App\Domains\Auditoria\Aggregates\Auditoria`

```php
final readonly class Auditoria implements AggregateModelContract
{
    public function __construct(
        private AuditoriaId         $id,
        private UsuarioId           $user_id,
        private AuditableTypes      $auditable_type,
        private AuditableRegisterId $auditable_id,
        private AuditableActions    $action,
        private ?JsonPayload        $old_values,  // null en CREATE
        private ?JsonPayload        $new_values,  // null en DELETE
    ) {}
}
```

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `AuditoriaId` | UUID v7 |
| Usuario | `UsuarioId` | Quién realizó la acción |
| Registro auditado | `AuditableRegisterId` | UUID del recurso modificado |
| Valores | `JsonPayload` | Snapshot JSON del agregado antes/después |

---

## Evento de Aplicación: `AuditableActionOcurred`

```php
final readonly class AuditableActionOcurred implements EventContract
{
    public function __construct(
        private ?PrimitiveAggregateModelContract $old_aggregate,  // null en CREATE
        private ?PrimitiveAggregateModelContract $new_aggregate,  // null en DELETE
        private AuditableActions $action,
        private AuditableTypes   $type,
        private Date $ocurredOn = new Date(new DateTimeImmutable())
    ) {}
}
```

El evento es publicado por los Handlers de escritura de los módulos auditables inmediatamente después de persistir el cambio.

**Ejemplo de publicación en `StoreMovimientoHandler`:**
```php
$this->eventBus->publish(new AuditableActionOcurred(
    old_aggregate: null,
    new_aggregate: $movimiento,
    type: AuditableTypes::MOVIMIENTOS,
    action: AuditableActions::CREATE
));
```

---

## Flujo de Auditoría

![Flujo](./../auditoria_flow_diagram.svg)

---

## Reglas de Negocio

1. **Solo lectura para el admin**: el módulo no tiene operaciones de escritura expuestas a través de la UI de usuario.
2. **`old_values` es `null` en CREATE**: no hay estado previo.
3. **`new_values` es `null` en DELETE**: el estado nuevo es "no existe".
4. **Los valores se almacenan como JSON** llamando a `$aggregate->toPrimitive()`.
5. **El usuario se captura automáticamente** desde el servicio de autenticación en el EventHandler.

---

## Esquema de Base de Datos

Tabla: `auditorias`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `user_id` | UUID (FK → users, cascade) | No | Usuario que realizó la acción |
| `auditable_type` | varchar | No | Módulo auditado (movimientos, etc.) |
| `auditable_id` | UUID | No | ID del registro modificado |
| `action` | enum('create','update','delete') | No | Tipo de acción |
| `old_values` | json | Sí | Estado anterior del registro |
| `new_values` | json | Sí | Estado nuevo del registro |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Índice:** `(auditable_type, auditable_id)`
