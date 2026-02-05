# Roadmap y pendientes - Proyecto Finanzas del Hogar

## 1. Base de datos
- [Completado ] Agregar columna `tipo_presupuesto_id` en `presupuestos`
- [Completado ] Ajustar unique key de `presupuestos` incluyendo `tipo_presupuesto_id`
- [ Completado ] Crear seed para `tipo_presupuesto`
- [ Completado ] Revisar soft deletes en `categorias` y `cuentas`
- [ Completado ] Revisar índices para reportes trimestrales y anuales
- [ completado] Crear Tabla de `movimiento_pendientes` 
- [Completado ] Crear Tabla de `movimientos` y asociarla con `movimeinto_pendientes` 
-[ Completado] Eliminar la tabla de tipo_presupuesto y sus relaciones

## 2. Backend / Laravel
- [ ] Crear Jobs o Tasks para registro automático de movimientos fijos
- [ ] sumar y restar el saldo actual de una cuenta cuando se realicen movimientos
- [ ] verificar antes de crear un movimiento, que la cuenta tenga saldo suficiente para hacerlo
- [ ] Script para registrar movimientos automáticos diarios
- [Parcial ] Validaciones de tablas con relaciones antes de eliminar, no permitir sin antes reasignar
- [ ] crear Jobs o Tasks para los sofdeletes de movimientos pendientes vencidos, para mostrarlos en la configuracion del sistema
- [Completado ] terminar de hacer la migration de archivos_movimientos y completar el backend de movimientos_pendientes para que en la marcacion de pagado, inserte en movimientos y suba los archivos que llegan desde el frontend
- [ COmpletado ] Eliminar el modulo de presupuestos por periodo, ya que no hace sintonia con la app

## 3. Frontend / UX
- [ Parcial] Interfaces separadas para:
    - Movimientos espontáneos (crear/editar)
    - Movimientos fijos
    - Movimientos históricos (solo lectura)
    - Movimientos Pendientes (gastos o ingresos)
- [Completado ] TransitionsMotion en tablas históricas
- [ ] Botón de registrar movimiento automático 
- [ ] Ocultar Boton de Eliminar para registros de modelos que tengan relaciones asociadas 
- [Completado ] Componentes para la interfaz de Movimientos Pendientes:
    - Boton para abrir modal de confirmacion de pago 
    - Tabla en la cual muestra el movimiento proveniente, y si no tiene (creado manualmente) muestra **NO APLICA**
- [Completado ] Ajustar el modal de marcar como pagado de movimientos_pendientes
- [Completado ] Terminar de mostrar los modales de show en los modulos que corresponden


## 4. Reportes
- [ Completado] Separación por tipo de presupuesto (operativo / planificado / ahorro)
- [ ] Asociar movimientos con presupuestos vía JOIN y BETWEEN
- [ Completado] Manejo de presupuestos anuales, semestrales y mensuales correctamente

## 5. Pendientes menores / UX
- [ ] Crear sección para registros eliminados (archivadas)  
- [ ] Crear componentes reutilizables sencillos de PDF + nombre del archivo y un rounded-icon que sea un boton 

