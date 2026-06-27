# Lenguaje Ubicuo — Leo Counter

Este glosario define los términos del dominio de negocio utilizados en todo el sistema Leo Counter. Todos los desarrolladores, diseñadores y stakeholders deben usar estos términos de forma consistente para evitar ambigüedades.

---

## Glosario General

### A

**Acreditar**
Incrementar el saldo de una `Cuenta`. Ocurre cuando se registra un ingreso o cuando se es destino de una Transferencia.

**Auditoría / Auditoria**
Registro inmutable de un cambio crítico realizado sobre un módulo auditable. Almacena los valores anteriores (`old_values`) y nuevos (`new_values`) del agregado afectado, quién realizó la acción y cuándo. Solo lectura para el rol `admin`.

### C

**Canal (de Notificación)**
Medio a través del cual el sistema puede enviar alertas. En la versión actual, el canal implementado es el correo electrónico. Puede estar activo o inactivo. Configurado por el administrador.

**Categoría / Categoria**
Etiqueta que clasifica un Movimiento o Presupuesto. Tiene un tipo (`INGRESO` o `GASTO`) y una bandera `es_fijo` que indica si suele ser recurrente (p. ej., "Arriendo" es `es_fijo = true`). Las categorías son únicas por combinación de nombre + tipo de movimiento.

**Comprobante**
Archivo adjunto a un Movimiento (factura, recibo, etc.). Se gestiona a través del módulo `ArchivoMovimiento` y se almacena en el storage local.

**Cuenta**
Representación de una cuenta financiera real (cuenta bancaria, efectivo, billetera digital, etc.). Tiene un `saldo_inicial` y un `saldo_actual`. El `saldo_actual` es actualizado automáticamente por eventos de dominio al registrar o eliminar Movimientos y Transferencias. Pertenece a un `Propietario`.

### D


**Días de Aviso (`dias_aviso`)**
Campo opcional en `MovimientoFijo` y `MovimientoPendiente`. Indica cuántos días antes de la fecha programada el sistema debe emitir una notificación de aviso.

### E

**Estado (de MovimientoPendiente)**
Ciclo de vida de un Movimiento Pendiente. Los estados posibles son:
- `PENDIENTE`: No ha sido realizado.
- `REALIZADO`: Fue marcado como hecho (pasó a ser un Movimiento real).
- `VENCIDO`: La fecha programada ya pasó sin ser marcado como realizado.

### F

**Fecha Programada (`fecha_programada`)**
Fecha en que se planea ejecutar un `MovimientoPendiente`.

**Fecha Próximo (`fecha_proximo`)**
Fecha en que se ejecutará la siguiente ocurrencia de un `MovimientoFijo`.

**Frecuencia**
Periodicidad de un `MovimientoFijo`. Los valores posibles son: `DIARIO`, `SEMANAL`, `QUINCENAL`, `MENSUAL`, `BIMESTRAL`, `TRIMESTRAL`, `SEMESTRAL`, `ANUAL`.

### G

**GASTO**
Tipo de movimiento que reduce el saldo de una cuenta. Identificado como `TipoMovimientoEnum::GASTO` (valor `2`).

### H

**Histórico**
Vista de solo lectura de Movimientos o Presupuestos del pasado. No permite creación, edición ni eliminación. Los Movimientos históricos son aquellos en la tabla `movimientos` con antigüedad suficiente (definida por la lógica del módulo Historial).

### I

**INGRESO**
Tipo de movimiento que incrementa el saldo de una cuenta. Identificado como `TipoMovimientoEnum::INGRESO` (valor `1`).

### M

**Monto**
Valor monetario de un Movimiento, Transferencia, Presupuesto o MovimientoFijo. Representado internamente como `Amount` (almacenado en centavos como entero). Siempre positivo.

**Mark as Done (Marcar como Realizado)**
Acción que transiciona un `MovimientoPendiente` del estado `PENDIENTE` al estado `REALIZADO`. Al ejecutarse, puede generar un `Movimiento` real en el sistema.

**Movimiento**
Hecho contable que representa un flujo de dinero ya realizado. Puede ser un ingreso o un gasto. Es el agregado central del sistema financiero. Tiene una `Cuenta`, una `Categoría`, un `TipoMovimiento`, un monto y una fecha.

**Movimiento Espontáneo**
Movimiento creado manualmente por el usuario en el momento. Contrasta con los Movimientos generados automáticamente desde un `MovimientoFijo`. Usa las mismas tablas y agregados que cualquier Movimiento, pero con una ruta CRUD dedicada.

**Movimiento Fijo**
Plantilla de un movimiento recurrente. Contiene una frecuencia y una fecha de próximo registro. El sistema (mediante el scheduler diario) procesa los que tienen `registrar_automatico = true` y/o envía notificaciones de aviso. No es un Movimiento en sí mismo.

**Movimiento Pendiente**
Movimiento que se planifica para el futuro pero aún no se ha realizado. Puede ser creado manualmente o generado automáticamente por un `MovimientoFijo`. Al marcarse como realizado, crea un `Movimiento` vinculado.

### P

**Papelera (Soft Deletes)**
Registros eliminados lógicamente (con `deleted_at`) que el administrador puede restaurar o eliminar permanentemente. Disponible en `Cuentas`, `Categorías`, `MovimientosPendientes`, `Presupuestos`.

**Período (`periodo`)**
En el contexto de `Presupuesto`, es el mes al que aplica el presupuesto, almacenado como fecha con formato `YYYY-MM`.

**Presupuesto**
Límite de gasto establecido para una `Categoría` en un mes específico. La combinación `(categoria_id, periodo)` es única. Puede duplicarse al mes siguiente.

**Propietario**
Persona dueña de una o más `Cuentas`. Tiene nombre, apellido, y opcionalmente teléfono y correo. La relación con Cuenta es `1:N`.

### R

**Recalcular Fecha Próxima**
Operación que ejecuta el sistema después de procesar un `MovimientoFijo`. Calcula la próxima fecha de ocurrencia según la frecuencia configurada, usando el patrón Strategy (`RecalculateNextDateResolver`).

**Reporte**
Módulo de estadísticas financieras multi-dominio, multi-estadistico y multi-filtrado. Agrupa métricas de Movimientos y Presupuestos con filtros dinámicos (rango de fechas, cuentas, categorías). Produce KPIs, comparativas ingresos vs gastos, distribución por categoría y análisis de presupuestos usados.

**Rol**
Nivel de acceso de un `Usuario`. Los roles disponibles son `admin` y `member`. Solo el rol `admin` tiene acceso a: Usuarios (CRUD), Configuración (canales, suscriptores, papelera) y Auditorías.

### S

**Saldo Actual (`saldo_actual`)**
Saldo vigente de una `Cuenta`, calculado en tiempo real mediante la aplicación de eventos de dominio. Nunca se calcula mediante una suma de transacciones en el momento de la consulta; se actualiza evento a evento.

**Saldo Inicial (`saldo_inicial`)**
Saldo con el que se crea una `Cuenta`. Si no hay movimientos previos, el `saldo_actual` iguala al `saldo_inicial`. Si se actualiza el `saldo_inicial` sin movimientos previos, el `saldo_actual` se ajusta automáticamente.

**Suscriptor (de Notificación)**
Usuario del sistema suscrito a un Canal de Notificación. La suscripción requiere verificación. Puede estar activa o inactiva.

### T

**Tipo de Cuenta (`tipo_cuenta_id`)**
Clasificación de una `Cuenta` (p. ej., cuenta corriente, efectivo, ahorros). Es una tabla de referencia (`tipo_cuentas`).

**Tipo de Movimiento (`TipoMovimientoEnum`)**
Enum que clasifica un Movimiento o plantilla como `INGRESO` (1) o `GASTO` (2).

**Transferencia**
Flujo de dinero entre dos `Cuentas` del sistema. No entra ni sale dinero del sistema total; solo se redistribuye. Genera un evento `TransferenciaCreated` que debita la cuenta de origen y acredita la cuenta de destino.

### U

**Usuario**
Entidad que puede iniciar sesión en el sistema. Tiene un rol (`admin` o `member`). El primer usuario creado es siempre `admin` (mediante el flujo de registro inicial o `CreateTheAdminUserHandler`).

### V

**Vencido**
Estado de un `MovimientoPendiente` cuya `fecha_programada` ya pasó sin que el usuario lo marcara como realizado. El sistema lo marca automáticamente mediante el scheduler y luego lo elimina.

---

## Relaciones entre Conceptos Clave
![Flujo](./../ubiquitous_flow.svg)
