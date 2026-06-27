# Dominio: Categoría

## Propósito del Módulo

Las categorías son **etiquetas de clasificación** que se asignan a Movimientos, MovimientosFijos, MovimientosPendientes y Presupuestos. Cada categoría está ligada a un tipo de movimiento (`INGRESO` o `GASTO`) y tiene una bandera `es_fijo` que indica si suele ser recurrente.

---

## Agregado: `Categoria`

El dominio `Categoria` vive en `app/Domains/Categoria/`. El agregado tiene los campos `id`, `nombre`, `tipo_movimiento_id`, `es_fijo`, `descripcion` e `is_system`.

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `CategoriaId` (extiende `DomainId`) | UUID v7 |

### Reglas de Negocio

1. **Nombre único por tipo**: la combinación `(nombre, tipo_movimiento_id)` tiene restricción `UNIQUE` en BD.
2. **`es_fijo`**: bandera que indica si la categoría suele asociarse a movimientos recurrentes (p. ej., "Arriendo"). Se puede activar/desactivar mediante `PATCH /categorias/{categoria}/{attribute}/toggle`.
3. **`is_system`**: categorías creadas por seeders del sistema. No pueden eliminarse.
4. **Soft delete**: las categorías pueden enviarse a la papelera.

---

## Esquema de Base de Datos

Tabla: `categorias`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Nombre de la categoría |
| `tipo_movimiento_id` | int (FK → tipo_movimientos) | No | INGRESO=1 o GASTO=2 |
| `es_fijo` | boolean | No | ¿Es recurrente? (default false) |
| `descripcion` | text | Sí | Descripción opcional |
| `is_system` | boolean | No | ¿Es del sistema? (default false) |
| `deleted_at` | timestamp | Sí | Soft delete |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Restricción única:** `(nombre, tipo_movimiento_id)`
**Índice:** `(tipo_movimiento_id)`
