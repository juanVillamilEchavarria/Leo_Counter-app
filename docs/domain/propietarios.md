# Dominio: Propietario

## Propósito del Módulo

El módulo `Propietario` representa a la persona dueña de una o más `Cuentas`. La relación con `Cuenta` es `1:N` (un propietario puede tener muchas cuentas). Es un módulo de soporte que da contexto a las cuentas financieras.

---

## Agregado: `Propietario`

**Namespace:** `App\Domains\Propietario\Aggregates\Propietario`

### Campos

```
id: PropietarioId (UUID v7)
nombre: string
apellido: string
telefono: string
email: Email
```

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `PropietarioId` (extiende `DomainId`) | UUID v7 |
| Identidad | `Email` | email valido |

### Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `PropietarioRepositoryContract` | CRUD del agregado |
| `PropietarioUniquenessCheckerContract` | Verifica unicidad del email del propietario |
| `PropietarioHasCuentasCheckerContract` | Verifica si el propietario tiene cuentas activas (bloquea eliminación) |

### Reglas de Negocio

1. **Email único**: si se provee email, debe ser único entre propietarios.
2. **No se puede eliminar un propietario con cuentas**: `CannotDeletePropietarioException` si el checker detecta cuentas asociadas.

---

## Esquema de Base de Datos

Tabla: `propietarios`

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `nombre` | varchar | No | Primer nombre |
| `apellido` | varchar | No | Apellido |
| `telefono` | varchar | Sí | Teléfono de contacto |
| `email` | varchar | Sí | Correo de contacto |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |
