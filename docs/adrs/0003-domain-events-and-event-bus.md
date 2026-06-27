# ADR-0003: Sistema de Eventos de Dominio y Bus de Eventos

- **Estado:** Aceptada
- **Fecha:** 2026-06-03
- **Autores:** Juan Esteban Villamil Echavarria

---

## Contexto

Leo Counter tiene flujos de negocio en los que una sola acción desencadena múltiples efectos secundarios en diferentes contextos:

1. **Registrar un Movimiento** debe:
   - Impactar el saldo de la `Cuenta` asociada (efecto financiero).
   - Guardar los comprobantes adjuntos si los hay (efecto de archivos).
   - Registrar la acción en el log de auditoría (efecto de auditoría).

2. **Eliminar un Movimiento** debe:
   - Revertir el efecto en el saldo de la `Cuenta`.
   - Eliminar los archivos adjuntos del storage.

3. **Crear una Transferencia** debe:
   - Debitar la cuenta de origen.
   - Acreditar la cuenta de destino.

Si estos efectos se implementan directamente dentro del `Handler`, el Handler viola el principio de responsabilidad única (SRP) y genera acoplamiento fuerte entre módulos de dominio distintos.

## Decisión

Se adopta un **sistema de eventos en dos niveles**:

### Nivel 1: Eventos de Dominio (grabados por el Agregado)

Los agregados que necesitan comunicar cambios usan el trait `RecordsEvents`:

```php
trait RecordsEvents
{
    private array $recordedEvents = [];

    protected function recordThat(EventContract $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}
```

El repositorio de Infraestructura libera los eventos después de persistir el agregado:

```php
// EloquentMovimientoRepository::store()
$this->model->create($movimiento->toPrimitive());
$this->eventBus->publishMany($movimiento->releaseEvents());
```

**Eventos de dominio existentes:**

| Evento | Agregado emisor | Propósito |
|--------|-----------------|-----------|
| `MovimientoCreated` | `Movimiento` | Impacto financiero en Cuenta al crear |
| `MovimientoDeleted` | `Movimiento` | Revertir impacto financiero al eliminar |
| `TransferenciaCreated` | `Transferencia` | Aplicar débito/crédito entre cuentas |

### Nivel 2: Eventos de Aplicación (publicados por el Handler)

Los `Handlers` publican eventos de aplicación directamente al `EventBus` para coordinación cross-cutting:

```php
// En StoreMovimientoHandler
$this->eventBus->publish(new AttachmentsForMovimientoCreated(
    movimiento: $movimiento,
    comprobantes: $command->comprobantes
));
$this->eventBus->publish(new AuditableActionOcurred(
    old_aggregate: null,
    new_aggregate: $movimiento,
    type: AuditableTypes::MOVIMIENTOS,
    action: AuditableActions::CREATE
));
```

**Algunos eventos de aplicación existentes:**

| Evento | Handler suscriptor | Propósito |
|--------|--------------------|-----------|
| `AttachmentsForMovimientoCreated` | `UploadAttachmentsWhenMovimientoIsWrittenEventHandler` | Subir archivos al storage |
| `AttachmentsForMovimientoUpdated` | `UpdateAttachmentsWhenMovimientoIsWrittenEventHandler` | Actualizar archivos |
| `AttachmentsForMovimientoDeleted` | `DestroyAttachmentsWhenMovimientoIsWrittenEventHandler` | Eliminar archivos |
| `AuditableActionOcurred` | Handler de Auditoría | Registrar en tabla `auditorias` |
| `AutomatedMovimientoFijoProcessed` | `LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler`| Notificación de procesamiento automático |
| `MovimientoFijoWarningDayArrived` | `LaravelSendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler` | Notificación de día de aviso |

### Implementación del EventBus

```php
class LaravelEventBus implements EventBus
{
    public function publish(EventContract $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    public function publishMany(array $events): void
    {
        foreach ($events as $event) {
            $this->publish($event);
        }
    }
}
```

## Alternativas Consideradas

| Alternativa | Pros | Contras |
|-------------|------|---------|
| Efectos directos en Handler | Simplicidad | SRP violado, alta cohesión, difícil de testear y extender |
| Observer pattern de Eloquent | Integración ORM nativa | Acopla la infraestructura con la lógica de dominio |

## Consecuencias

**Positivas:**
- Los `EventHandlers` (p. ej., `MovimientoCreatedFinancialImpactEventHandler`) son unidades independientes testeables.
- Añadir un nuevo efecto secundario requiere solo un nuevo `EventHandler` y registrarlo en el `EventServiceProvider`, sin modificar el `Handler` original.
- Los eventos de dominio garantizan que el agregado ya está persistido antes de publicar (el repositorio libera los eventos post-persistencia).

**Negativas / Trade-offs:**
- El flujo de ejecución es menos obvio: hay que seguir los registros de listeners para entender la cadena completa.

## Referencias

- `app/Shared/Domain/Traits/RecordsEvents.php`
- `app/Shared/Infrastructure/Framework/Laravel/Buses/LaravelEventBus.php`
- `app/Application/Movimiento/EventHandlers/`
- `app/Shared/Application/Events/AuditableActionOcurred.php`
- `app/Providers/EventServiceProvider.php`
