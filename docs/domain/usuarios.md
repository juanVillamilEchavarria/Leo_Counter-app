# Dominio: Usuario

## Propósito del Módulo

El módulo `Usuario` gestiona las cuentas de acceso al sistema. Solo el rol `admin` puede administrar usuarios (CRUD). El primer usuario es siempre el administrador, creado mediante el flujo de registro inicial.

---

## Agregado: `Usuario`

**Namespace:** `App\Domains\Usuario\Aggregates\Usuario`

### Campos

```
id: UsuarioId (UUID v7)
name: string
email: Email (VO)
password: Password (VO)
role: Roles (enum)
```

### Value Objects

| VO | Clase | Descripción |
|----|-------|-------------|
| Identidad | `UsuarioId` (extiende `DomainId`) | UUID v7 |
| Email | `Email` | Validación de formato |
| Password | `Password` | Hash bcrypt |

---

## Enum: `Roles`

```php
enum Roles: string
{
    case ADMIN  = 'admin';
    case MEMBER = 'member';
}
```

---

## Casos de Uso Disponibles

| Comando / Query | Propósito |
|-----------------|-----------|
| `CreateTheAdminUserCommand` | Crea el primer usuario administrador |
| `StoreUsuarioCommand` | Crea un usuario (solo admin) |
| `UpdatePublicDataCommand` | Actualiza nombre/email del usuario |
| `ChangeUserPasswordCommand` | Cambia contraseña de otro usuario (solo admin) |
| `ChangeOwnPasswordCommand` | Cambia la propia contraseña |
| `DestroyUsuarioCommand` | Elimina un usuario (no al admin principal) |
| `ListAllUsuariosQuery` | Lista todos los usuarios |
| `GetUsuarioForEditQuery` | Obtiene datos para el formulario de edición |

---

## Reglas de Negocio

1. **El usuario admin principal no puede eliminarse**: `CannotDeleteUsuarioException`.
2. **Email único**: `UsuarioUniquinessCheckerContract` verifica unicidad antes de crear/actualizar.
3. **No se puede cambiar la contraseña del admin sin confirmación de la contraseña actual**: `WrongPasswordException`.
4. **El primer registro** siempre es de rol `admin` (`CreateTheAdminUserHandler`).
5. **Roles**: `admin` (acceso total) y `member` (acceso restringido a funciones financieras).
6. **`CannotUpdateUserDataRelatedToANotificationChannel`**: excepción cuando se intenta actualizar datos que afectarían un canal de notificación verificado.

---

## Contratos de Dominio

| Contrato | Propósito |
|----------|-----------|
| `UsuarioRepositoryContract` | CRUD del agregado |
| `UsuarioUniquinessCheckerContract` | Verifica unicidad de email |
| `UsuarioCanUpdatePublicDataCheckerContract` | Verifica que los datos públicos son actualizables |
| `PasswordHasherContract` | Abstracción de hashing de contraseñas |

---

## Esquema de Base de Datos

Tabla: `users` (Laravel estándar + campo `role`)

| Columna | Tipo | Nulo | Descripción |
|---------|------|------|-------------|
| `id` | UUID (PK) | No | UUID v7 |
| `name` | varchar | No | Nombre del usuario |
| `email` | varchar (unique) | No | Correo de acceso |
| `email_verified_at` | timestamp | Sí | Verificación |
| `password` | varchar | No | Hash bcrypt |
| `role` | varchar | No | 'admin' o 'member' |
| `remember_token` | varchar | Sí | Sesión persistente |
| `created_at` / `updated_at` | timestamps | — | Auditoría técnica |
