# Dominio: Notificaciones

## Propósito del Módulo

El módulo `Notificacion` gestiona el sistema de alertas del sistema. Permite al administrador configurar **canales de notificación** (medios de envío) y **suscriptores** (usuarios que reciben alertas por esos canales). Actualmente el único canal implementado es el correo electrónico.

Las notificaciones se envían automáticamente cuando el scheduler detecta días de aviso en `MovimientosFijos` o `MovimientosPendientes`.

---

## Agregado: `Canal`

**Namespace:** `App\Domains\Notificacion\Aggregates\Canal`

Representa un medio de notificación (p. ej., "Email"). Puede estar activo o inactivo.

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `CanalId` | UUID v7 |

### Enum: `CanalesNotificacionEnum`

```php
enum CanalesNotificacionEnum: string
{
    CASE EMAIL = 'Email';
    // Define los canales disponibles en el sistema
    // (correo electrónico, etc.)
}
```

---

## Agregado: `Suscriptor`

**Namespace:** `App\Domains\Notificacion\Aggregates\Suscriptor`

Representa la suscripción de un `Usuario` a un `Canal`. Requiere verificación antes de activarse.

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `SuscriptorId` | UUID v7 |

### Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `CanalRepositoryContract` | CRUD del agregado Canal |
| `SuscriptorRepositoryContract` | CRUD del agregado Suscriptor |
| `SuscriptorUniquenessCheckerContract` | Verifica que un usuario no se suscriba dos veces al mismo canal |
| `SuscriptorCreated` | Evento para enviar verificación al nuevo suscriptor |

---

## Reglas de Negocio

1. **Un usuario solo puede suscribirse una vez a cada canal**: restricción `UNIQUE (user_id, canal_notificacion_id)`.
2. **La suscripción requiere verificación**: `verified_at` es `null` hasta que el suscriptor confirme mediante el enlace firmado `GET /suscriptores/verificar/{suscriptorId}`.
3. **El canal puede activarse/desactivarse**: mediante `PATCH /canal-notificaciones/{canal}/{attribute}/toggle`.
4. **El suscriptor puede activarse/desactivarse**: mediante `PATCH /suscriptor-notificaciones/{suscriptor}/{attribute}/toggle`.
5. **Solo el admin gestiona canales y suscriptores**.

---

## Flujo de Verificación de Suscripción
![Flujo](./../suscriptor_verification_flow_diagram.svg)

---

## Esquema de Base de Datos

### Tabla: `canales_notificacion`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar (unique) | No | Nombre del canal |
| `active` | boolean | No | Canal activo (default false) |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

### Tabla: `suscriptores_notificaciones`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `user_id` | UUID (FK → users) | No | Usuario suscrito |
| `canal_notificacion_id` | UUID (FK → canales_notificacion) | No | Canal de notificación |
| `active` | boolean | No | Suscripción activa (default true) |
| `verified_at` | timestamp | Sí | Cuándo se verificó (null = pendiente) |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |

**Restricción única:** `(user_id, canal_notificacion_id)`
