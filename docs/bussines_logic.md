# Lógica de negocio - Proyecto Finanzas del Hogar

## 1. Objetivo general
- La app permite a un hogar gestionar ingresos, gastos, movimientos fijos y presupuestos.
- Permite generar reportes por categoría, tipo de presupuesto y periodo.

## 2. Conceptos clave
- **Movimientos:** transacciones Realizadas.
- **Movimientos fijos:** transacciones recurrentes con fecha de próximo registro.
- **Movimientos pendientes:** transacciones esperadas.
- **Presupuestos:** límites de gasto o ahorro por categoría y periodo.

## 3. Reglas de negocio
- Los **movimientos fijos** se registran automáticamente en **movimientos pendientes** según su frecuencia y segun si el fijo esta marcado como registro automatico, automaticamente se genera la instancia de **movimientos** mediante el registro creado en **movimientos pendientes** (fijos->pendientes->movimientos).
- Los **movimientos espontáneos** se crean manualmente y se registran directamente en movimientos sin pasar antes por otra tabla o modelo, pues son movimientos generados en el momento, **ESPONTANEOS** (un cafe, una salida a comer, etc).
- Movimientos se asignan a presupuestos en los reportes usando **JOINs y rango de fechas (BETWEEN)**.
- No se elimina información histórica; se usan **soft deletes** para categorías, cuentas y presupuestos.
- Se pueden archivar categorías o cuentas en lugar de eliminarlas.
-Los movimientos representan hechos financieros reales. En el contexto de un hogar, muchos de estos movimientos se repiten de forma periódica (pago de servicios, deudas, mercado, ingresos fijos, etc.).

Por esta razón, se define el concepto de movimientos fijos, cuyo objetivo es evitar que el usuario tenga que registrar manualmente cada mes la misma operación, facilitando además una mejor auditoría, control y trazabilidad de los movimientos recurrentes, incluso cuando su monto pueda variar.

Por otro lado, los presupuestos representan límites o intenciones de gasto, los cuales son altamente variables mes a mes. Un presupuesto puede existir en un periodo específico y no volver a aparecer en los siguientes, o cambiar significativamente tanto en su monto como en su propósito.

Adicionalmente, el usuario creador del presupuesto (dato relevante para la trazabilidad y responsabilidad del límite establecido) puede variar de un periodo a otro.

Debido a esta variabilidad en existencia, monto, propósito y autoría, no es viable ni coherente establecer presupuestos fijos, ya que no reflejarían el comportamiento real de la planificación financiera en un entorno doméstico.

## 4. Flujo de operación
1. Usuario crea movimientos fijos o manuales.
2. Sistema registra automáticamente los movimientos fijos según la frecuencia.
3. Movimientos se agrupan por categoría y tipo de presupuesto para reportes.
4. Presupuestos permiten establecer límites de gasto o ahorro, y reportes muestran si se exceden.
5. Movimientos pendientes muestran movimientos fijos o manuales .

## 5. Reglas especiales
- Si un movimiento fijo es deshabilitado para registro automático, se tendra que marcar como realizado de manera manual en **movimientos_pendientes**, de lo contrario, si esta habilitado el registro automatico, se movera igualmente a **movimientos_pendientes** pero se registrara automaticamente cuando llegue la fecha de vencimiento pues el Job corre cada dia verificando si la fecha de vencimiento es <=hoy, se hace esto con la posibilidad de que el usuario pueda confirmar su pago antes, o añadirle un comprobante, si es asi, se marca como realizado el mismo dia que el usuario lo confirma.
- **movimientos_pendientes** tienen un estado (realizado, pendiente o vencido), se sabra si el registro fue automatico o manual si la instancia generada en movimientos tiene relacion con movimientos_pendientes
