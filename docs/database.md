# Documentación de Base de Datos
Este documento describe **el propósito (para qué)** y **la justificación (por qué)** de cada tabla existente hasta el momento en la base de datos del sistema **Proyecto Finanzas del Hogar**.

El objetivo de esta documentación es dejar claro el **sentido funcional y técnico** de cada entidad, facilitando el mantenimiento, la escalabilidad y la comprensión futura del sistema.

---

## 1. Tabla `users`

### ¿Para qué existe?

Almacena los usuarios que pueden acceder al sistema. Representa la identidad digital de cada persona que utiliza la aplicación para gestionar sus finanzas.

### ¿Por qué es necesaria?

Es el núcleo del sistema de autenticación y autorización. Permite:

* Identificar a cada usuario de forma única.
* Gestionar accesos y roles dentro de la aplicación.
* Asociar acciones financieras a un usuario autenticado.

### Consideraciones clave

* El campo `email` es único para evitar duplicidad de cuentas.
* El campo `role` permite manejar distintos niveles de acceso (por ejemplo: administrador, miembro).
* Se utilizan timestamps para auditoría básica (creación y actualización).

---

## 2. Tabla `password_reset_tokens`

### ¿Para qué existe?

Gestiona los tokens necesarios para el proceso de recuperación de contraseña.

### ¿Por qué es necesaria?

Permite restablecer contraseñas de forma segura sin almacenar contraseñas temporales ni exponer credenciales sensibles.

### Consideraciones clave

* Usa el correo electrónico como clave primaria.
* El token tiene vigencia controlada por la fecha de creación.

---

## 3. Tabla `sessions`

### ¿Para qué existe?

Almacena la información de las sesiones activas de los usuarios.

### ¿Por qué es necesaria?

Permite:

* Mantener la sesión del usuario autenticado.
* Controlar múltiples sesiones.
* Mejorar la seguridad y trazabilidad de accesos.

### Consideraciones clave

* Relación indirecta con `users` mediante `user_id`.
* Guarda información técnica como IP y agente de usuario.

---

## 4. Tabla `cache`

### ¿Para qué existe?

Almacena datos temporales en caché para mejorar el rendimiento del sistema.

### ¿Por qué es necesaria?

Reduce el número de consultas y cálculos repetitivos, optimizando tiempos de respuesta.

---

## 5. Tabla `cache_locks`

### ¿Para qué existe?

Gestiona bloqueos de caché para evitar condiciones de carrera.

### ¿Por qué es necesaria?

Garantiza consistencia cuando múltiples procesos intentan modificar el mismo recurso en caché.

---

## 6. Tabla `jobs`

### ¿Para qué existe?

Almacena tareas en cola para ser procesadas de manera asíncrona.

### ¿Por qué es necesaria?

Permite ejecutar procesos pesados o diferidos (notificaciones, cálculos, procesos automáticos) sin afectar la experiencia del usuario.

---

## 7. Tabla `job_batches`

### ¿Para qué existe?

Agrupa múltiples trabajos (`jobs`) en un mismo lote.

### ¿Por qué es necesaria?

Facilita el control, seguimiento y cancelación de procesos masivos.

---

## 8. Tabla `failed_jobs`

### ¿Para qué existe?

Registra los trabajos que fallaron durante su ejecución.

### ¿Por qué es necesaria?

Permite:

* Diagnosticar errores.
* Reintentar procesos fallidos.
* Mantener la estabilidad del sistema.

---

## 9. Tabla `tipo_cuentas`

### ¿Para qué existe?

Define los distintos tipos de cuentas financieras (ejemplo: ahorro, corriente, efectivo).

### ¿Por qué es necesaria?

Normaliza la información y evita valores repetidos o inconsistentes en las cuentas.

### Consideraciones clave

* Permite extender el sistema con nuevos tipos sin modificar la lógica central.

---

## 10. Tabla `propietarios`

### ¿Para qué existe?

Representa a los propietarios de las cuentas financieras.

### ¿Por qué es necesaria?

Permite separar el concepto de **usuario del sistema** del **dueño real del dinero**, lo cual:

* Hace el sistema más flexible.
* Permite manejar finanzas familiares o de terceros.

---

## 11. Tabla `cuentas`

### ¿Para qué existe?

Almacena las cuentas financieras del sistema, como cuentas bancarias, efectivo o billeteras.

### ¿Por qué es necesaria?

Es una de las tablas centrales del sistema, ya que:

* Representa el origen y destino del dinero.
* Permite calcular balances y movimientos.

### Campos clave y decisiones importantes

* `saldo_inicial`: registra el estado financiero al momento de crear la cuenta.
* `saldo_actual`: refleja el saldo actualizado tras los movimientos.
* `tipo_cuenta_id`: clasifica la cuenta según su naturaleza.
* `propietario_id`: indica a quién pertenece el dinero.

### Campo `active`

Se utiliza para controlar si una cuenta está operativa sin necesidad de eliminarla.

### Campo `archived`

**Decisión de diseño importante**:

* No se eliminan cuentas de la base de datos.
* Cuando una cuenta deja de usarse, se archiva.

#### ¿Por qué se archivan y no se eliminan?

* Preserva el historial financiero.
* Evita pérdida de información contable.
* Es una mejor práctica en sistemas financieros.
* Permite auditoría y trazabilidad.

Archivar una cuenta significa que:

* No participa en operaciones activas.
* Sigue existiendo para consultas históricas.

---

## 12. Tabla `tipo_movimientos`

### ¿Para qué existe?

Define los **tipos base de movimiento financiero** del sistema, como:

- Ingresos  
- Gastos  

Funciona como una tabla de **clasificación principal** para todos los movimientos y categorías.

### ¿Por qué es necesaria?

Separar los tipos de movimiento en una tabla independiente permite:

* Evitar valores hardcodeados (`Ingreso`, `Gasto`) en otras tablas.
* Mantener consistencia semántica en todo el sistema.
* Facilitar futuras extensiones (por ejemplo: transferencias, ajustes, etc.).
* Simplificar validaciones y reglas de negocio.

### Campo clave

* `tipo_movimiento`: nombre único del tipo de movimiento (ej. *Ingreso*, *Gasto*).

Este campo es único porque:

* No pueden existir dos tipos de movimiento con el mismo significado.
* Garantiza integridad conceptual del sistema.

### Relación con otras tablas

* Se relaciona con la tabla `categorias`.
* Define el **sentido financiero** de cada categoría.

---

## 13. Tabla `categorias`

### ¿Para qué existe?

Representa las **categorías financieras** utilizadas para clasificar los movimientos, tales como:

- Alimentación
- Educación
- Vivienda
- Ingresos laborales
- Entretenimiento

Las categorías permiten organizar, analizar y generar reportes financieros detallados.

### ¿Por qué es necesaria?

Las categorías son fundamentales porque:

* Permiten agrupar movimientos financieros.
* Facilitan la generación de reportes y estadísticas.
* Ayudan al usuario a entender en qué gasta o de dónde proviene su dinero.
* Hacen el sistema flexible y personalizable.

---

### Relación con `tipo_movimientos`

Cada categoría pertenece a **un solo tipo de movimiento**:

* Una categoría es **exclusivamente de ingreso** o **exclusivamente de gasto**.
* Esto evita errores conceptuales, como usar una categoría de gasto en un ingreso.



## Nota final

Este diseño prioriza:

* Integridad de la información financiera.
* Buenas prácticas de sistemas contables.
* Escalabilidad y mantenimiento a largo plazo.

La documentación se irá ampliando conforme se agreguen nuevas tablas y reglas de negocio.
