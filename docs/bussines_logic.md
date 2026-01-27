# Lógica de negocio - Proyecto Finanzas del Hogar

## 1. Objetivo general
- La app permite a un hogar gestionar ingresos, gastos, movimientos fijos y presupuestos.
- Permite generar reportes por categoría, tipo de presupuesto y periodo.

## 2. Conceptos clave
- **Movimientos:** transacciones puntuales, manuales o automáticas.
- **Movimientos fijos:** transacciones recurrentes con fecha de próximo registro.
- **Presupuestos:** límites de gasto o ahorro por categoría y periodo.
- **Tipos de presupuesto:** Operativo (gastos mensuales), Planificado (gastos a mediano-largo plazo), Ahorro.

## 3. Reglas de negocio
- Los **movimientos fijos** se registran automáticamente en **movimientos pendientes** según su frecuencia y segun si el fijo esta marcado como registro automatico, automaticamente se genera la instancia de **movimientos** mediante el registro creado en **movimientos pendientes**.
- Los **movimientos espontáneos** se crean manualmente.
- Presupuestos de tipo **planificado** pueden ser semestrales o anuales, mientras que **operativo** normalmente es mensual.
- Movimientos se asignan a presupuestos en los reportes usando **JOINs y rango de fechas (BETWEEN)**.
- No se elimina información histórica; se usan **soft deletes** para categorías, cuentas y presupuestos.
- Se pueden archivar categorías o cuentas en lugar de eliminarlas.

## 4. Flujo de operación
1. Usuario crea movimientos fijos o manuales.
2. Sistema registra automáticamente los movimientos fijos según la frecuencia.
3. Movimientos se agrupan por categoría y tipo de presupuesto para reportes.
4. Presupuestos permiten establecer límites de gasto o ahorro, y reportes muestran si se exceden.
5. Pagos pendientes muestran movimientos fijos o manuales que requieren acción del usuario.

## 5. Reglas especiales
- Si un movimiento fijo es deshabilitado para registro automático, se mueve a **movimientos_pendientes**.
- El sistema permite crear **subpresupuestos** dentro de un presupuesto grande (ej: viajes anuales y viajes mensuales dentro del mismo tipo “planificado”).
