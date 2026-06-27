# API REST — Leo Counter

Los endpoints de `routes/api.php` están protegidos por el middleware `auth` (sesión de Laravel). No usan autenticación por token; la sesión se mantiene mediante cookies de sesión estándar.

> **Nota:** La mayoría de las operaciones CRUD (crear, editar, eliminar) usan rutas web (`routes/web.php`) con Inertia.js, no endpoints REST. Los endpoints de `api.php` están diseñados para ser consumidos por React Query desde el frontend para operaciones de **lectura paginada, generación de reportes y formularios dinámicos**.

---

## Base URL

```
http://localhost:8080/api
```

En producción, la base URL corresponde al dominio configurado.

---

## Autenticación

Todos los endpoints requieren una sesión activa (cookie `laravel_session`). El middleware `auth` rechaza las peticiones sin sesión con un redirect al login (o `401` para peticiones AJAX).

---

## Endpoints Disponibles

### Validación de Saldo

#### `POST /api/validate-saldo`

Valida si una cuenta tiene saldo suficiente para una operación.

- **Controlador:** `SaldoValidateController`
- **Middleware:** `auth`
- **Nombre de ruta:** `api.validate-saldo`
- **Body:** `{ cuenta_id: string, monto: number }`
- **Respuesta:** `{ valid: boolean, mensaje?: string }`

---

### Movimientos

#### `GET /api/movimientos`

Retorna la lista paginada de movimientos para la tabla server-side de TanStack Table.

- **Controlador:** `MovimientoApiController@totalPaginated`
- **Nombre de ruta:** `api.movimientos.total-paginated`
- **Query params:**

| Param | Tipo | Descripción |
|-------|------|-------------|
| `page` | int | Número de página (default 1) |
| `per_page` | int | Registros por página (default 10) |
| `search` | string? | Búsqueda por nombre |
| `cuenta_id` | string? | Filtro por cuenta |
| `categoria_id` | string? | Filtro por categoría |
| `tipo_movimiento_id` | int? | Filtro por tipo (1=INGRESO, 2=GASTO) |
| `fecha_desde` | date? | Filtro de fecha inicio |
| `fecha_hasta` | date? | Filtro de fecha fin |

- **Respuesta:** `PaginatedTableResultDTO`

```json
{
  "data": [...],
  "total": 150,
  "per_page": 10,
  "current_page": 1,
  "last_page": 15
}
```

---

### Auditorías

#### `GET /api/auditorias`

Retorna la lista paginada de registros de auditoría.

- **Controlador:** `AuditoriaApiController@index`
- **Nombre de ruta:** `api.auditorias.index`
- **Acceso:** Solo rol `admin`
- **Query params:** `page`, `per_page`, `search`, `auditable_type`, `action`
- **Respuesta:** Lista paginada de auditorías con `old_values` y `new_values`.

---

### Presupuestos

#### `GET /api/presupuestos/historicos`

Retorna la lista paginada de presupuestos históricos.

- **Controlador:** `PresupuestoHistoricoApiController@historicosPaginated`
- **Nombre de ruta:** `api.presupuestos.historicos-paginated`
- **Query params:** `page`, `per_page`, `search`, `periodo_desde`, `periodo_hasta`
- **Respuesta:** Lista paginada de presupuestos históricos.

---

### Reportes

#### `GET /api/reportes`

Retorna las opciones para el formulario de reportes.

- **Controlador:** `ReporteApiController@index`
- **Nombre de ruta:** `api.reportes.index`

#### `POST /api/reportes/generate`

Genera un reporte financiero con los filtros especificados.

- **Controlador:** `ReporteApiController@generate`
- **Nombre de ruta:** `api.reportes.generate`
- **Body:**

```json
{
  "statistic_type": "income_expense_comparison",
  "date_range": { "from": "2026-01-01", "to": "2026-06-30" },
  "cuenta_ids": ["uuid1", "uuid2"],
  "categoria_ids": ["uuid3"]
}
```

- **Respuesta:** DTO del reporte solicitado (KPI, comparativa, distribución, etc.)

#### `GET /api/reportes/form-options`

Retorna las opciones disponibles para construir el formulario de reportes (tipos de reporte, cuentas, categorías, rangos).

- **Controlador:** `ReporteApiController@formOptions`
- **Nombre de ruta:** `api.reportes.form-options`

---

### Home / Dashboard

#### `GET /api/home`

Retorna los datos del dashboard (KPIs del mes actual, gráfico ingresos vs gastos).

- **Controlador:** `HomeApiController@index`
- **Nombre de ruta:** `api.home.index`
- **Respuesta:** Estadísticas del mes vigente.

---

### Notificaciones — Suscriptores

#### `GET /api/notificacion/suscriptores/form-options`

Retorna las opciones del formulario de suscriptores (canales disponibles).

- **Controlador:** `SuscriptorApiController@formOptions`
- **Nombre de ruta:** `api.notificaciones.suscriptor.form-options`

#### `POST /api/notificacion/suscriptores`

Crea una nueva suscripción y envía el correo de verificación.

- **Controlador:** `SuscriptorApiController@store`

#### `DELETE /api/notificacion/suscriptores/{suscriptor}`

Elimina una suscripción.

- **Controlador:** `SuscriptorApiController@destroy`

---

### Transferencias

#### `GET /api/transferencias`

Retorna la lista paginada de transferencias para la tabla server-side.

- **Controlador:** `TransferenciaApiController@totalPaginated`
- **Nombre de ruta:** `api.transferencias.total-paginated`
- **Query params:** `page`, `per_page`, `search`, `cuenta_origen_id`, `cuenta_destino_id`, `fecha_desde`, `fecha_hasta`
- **Respuesta:** Lista paginada de transferencias.

---

## Rutas Web con Efectos de Escritura

Las siguientes rutas web también tienen relevancia para el frontend (uso con `Inertia.js router.post/put/delete`):

| Método | Ruta | Controlador | Descripción |
|--------|------|-------------|-------------|
| `POST` | `/movimientos-espontaneos` | `MovimientoEspontaneoController@store` | Crear movimiento (con idempotencia) |
| `PUT` | `/movimientos-espontaneos/{id}` | `MovimientoEspontaneoController@update` | Actualizar movimiento |
| `DELETE` | `/movimientos-espontaneos/{id}` | `MovimientoEspontaneoController@destroy` | Eliminar movimiento |
| `PATCH` | `/movimientos-pendientes/{id}/mark-as-done` | `MovimientoPendienteController@markAsDone` | Marcar pendiente como realizado |
| `POST` | `/presupuestos/mes-actual/{id}/duplicate` | `PresupuestoMesActualController@duplicate` | Duplicar presupuesto al mes siguiente |
| `PATCH` | `/cuentas/{id}/{attribute}/toggle` | `CuentaController@toggleActive` | Activar/desactivar cuenta |
| `PATCH` | `/movimientos-fijos/{id}/{attribute}/toggle` | `MovimientoFijoController@toggle` | Activar/desactivar movimiento fijo |
| `PATCH` | `/categorias/{id}/{attribute}/toggle` | `CategoriaController@toggleEsFijo` | Activar/desactivar `es_fijo` |

---

## Middleware de Idempotencia

Las rutas de creación de Movimientos Espontáneos están protegidas por `IdempotencyMiddleware`. El cliente debe enviar un header `X-Idempotency-Key` único para prevenir registros duplicados ante reintentos de red.
