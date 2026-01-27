# Roadmap y pendientes - Proyecto Finanzas del Hogar

## 1. Base de datos
- [Completado ] Agregar columna `tipo_presupuesto_id` en `presupuestos`
- [Completado ] Ajustar unique key de `presupuestos` incluyendo `tipo_presupuesto_id`
- [ Completado ] Crear seed para `tipo_presupuesto`
- [ Completado ] Revisar soft deletes en `categorias` y `cuentas`
- [ Completado ] Revisar índices para reportes trimestrales y anuales
- [ ] Crear Tabla de `movimiento_pendientes` 
- [ ] Crear Tabla de `movimientos` y asociarla con `movimeinto_fijos` 

## 2. Backend / Laravel
- [ ] Crear Jobs o Tasks para registro automático de movimientos fijos
- [ ] Script para registrar movimientos automáticos diarios
- [Parcial ] Validaciones de tablas con relaciones antes de eliminar, no permitir sin antes reasignar
- [ ] crear Jobs o Tasks para los sofdeletes de movimientos pendientes vencidos, para mostrarlos en la configuracion del sistema

## 3. Frontend / UX
- [ Parcial] Interfaces separadas para:
    - Movimientos espontáneos (crear/editar)
    - Movimientos fijos
    - Movimientos históricos (solo lectura)
    - Movimientos Pendientes (gastos o ingresos)
- [Completado ] TransitionsMotion en tablas históricas
- [ ] Botón de registrar movimiento automático 
- [ ] Ocultar Boton de Eliminar para registros de modelos que tengan relaciones asociadas 
- [ ] Componentes para la interfaz de Movimientos Pendientes:
    - Boton para abrir modal de confirmacion de pago ( si es tipo gasto, muestra campo para subir opcionalmente un comprobante d epago y confirmacion, si es de tipo ingreso, solo la confirmacion)
    - Tabla en la cual muestra el movimiento proveniente, y si no tiene (creado manualmente) muestra **NO APLICA**

## 4. Reportes
- [ Completado] Separación por tipo de presupuesto (operativo / planificado / ahorro)
- [ ] Asociar movimientos con presupuestos vía JOIN y BETWEEN
- [ Completado] Manejo de presupuestos anuales, semestrales y mensuales correctamente

## 5. Pendientes menores / UX
- [Parcial ] Confirmar nombres de secciones: `movimientos_pendientes`  
- [ ] Crear sección para categorias eliminadas (archivadas)  
