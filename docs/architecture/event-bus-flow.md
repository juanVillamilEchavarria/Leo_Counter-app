# Flujo del Bus de Eventos — Leo Counter

Este documento describe en detalle el ciclo de vida de los eventos en Leo Counter, desde que un agregado los graba hasta que los event handlers ejecutan sus efectos secundarios.

---

## Arquitectura del Bus de Eventos

<p align="center">
  <img src="./../event_flow.svg" alt="Diagrama de Arquitectura Leo Counter" width="800">
</p>

---

## Flujo Detallado: Crear un Movimiento

![Flujo](./../create_movimientos_flow_diagram.svg)

---

## Flujo Detallado: Eliminar un Movimiento
![Flujo](./../delete_movimientos_flow_diagram.svg)

---

## Flujo Detallado: Crear una Transferencia

![Flujo](./../create_transferencia_flow_diagram.svg)

---

## Registro de Listeners

Los event handlers se registran en cada provider de cada dominio en Laravel. La tabla a continuación resume las suscripciones actuales:

| Evento | Listener / Handler |
|--------|--------------------|
| `MovimientoCreated` | `MovimientoCreatedFinancialImpactEventHandler` |
| `MovimientoDeleted` | `MovimientoDeletedFinancialImpactEventHandler` |
| `TransferenciaCreated` | `ApplyTransactionEffectForCuentaWhenTransferenciaWasCreatedEventHandler` |
| `AttachmentsForMovimientoCreated` | `UploadAttachmentsWhenMovimientoIsWrittenEventHandler` |
| `AttachmentsForMovimientoUpdated` | `UpdateAttachmentsWhenMovimientoIsWrittenEventHandler` |
| `AttachmentsForMovimientoDeleted` | `DestroyAttachmentsWhenMovimientoIsWrittenEventHandler` |
| `AuditableActionOcurred` | `RegisterForAuditEventHandler` |
| `MovimientoFijoWarningDayArrived` | `LaravelSendMessageToUserWhenMovimientoFijoWarningDayArrivedEventHandler` |
| `AutomatedMovimientoFijoProcessed` | `LaravelSendMessageToUserWhenMovimientoIsCreatedAutomatedFromAMovimientoFijoEventHandler` |

---

## Contratos de Evento

Todos los eventos implementan `EventContract`:

```php
interface EventContract
{
    public function ocurredOn(): Date;
}
```

Los eventos de dominio relacionados con movimientos implementan contratos adicionales:

```php
interface FinancialMovimientoRegisteredEventContract extends EventContract
{
    public function getMovimiento(): Movimiento;
}

interface DestroyAttachmentsForMovimientoEventContract extends EventContract { ... }
interface UploadAttachmentsForMovimientoEventContract extends EventContract { ... }
interface UpdateAttachmentsForMovimientoEventContract extends EventContract { ... }
```

---

## Nota sobre Transaccionalidad

Todos los comandos marcados con `TransactionalCommandContract` se ejecutan dentro de una transacción de base de datos gracias al `LaravelTransactionMiddleware`. Esto garantiza que si el `EventBus` lanza una excepción dentro de un `EventHandler` (p. ej., fallo al actualizar el saldo de la cuenta), toda la operación se revierte: ni el movimiento ni los cambios financieros quedan persistidos.
