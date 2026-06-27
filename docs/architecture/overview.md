# Visión General de la Arquitectura — Leo Counter

Leo Counter es una plataforma web autoalojada de gestión financiera personal, familiar y empresarial. El sistema sigue estrictamente los principios de **Clean Architecture**, **Domain-Driven Design (DDD)** y **CQRS**, organizados sobre Laravel 12 / PHP 8.5 como framework de infraestructura.

---

## Stack Tecnológico

| Capa | Tecnología |
|------|------------|
| Backend | Laravel 12, PHP 8.5 |
| Frontend | React 19, TypeScript, Inertia.js 2.0 |
| Estilos | Tailwind CSS 4.x |
| Tablas | TanStack Table v8 (server-side) |
| BD Principal | MariaDB LTS |
| Caché / Queues | Redis (alpine) |
| WebSockets | Laravel Reverb |
| Email de Dev | Mailhog |
| Contenedores | Docker + Docker Compose |
| Gestor paquetes JS | pnpm 9.x |
| Bundler | Vite 6.x |

---

## Capas de la Arquitectura

![Flujo](./../architecture_simple.svg)

---

## Flujo Completo de una Petición HTTP (Ejemplo: Crear Movimiento)

El siguiente diagrama muestra el recorrido de una petición desde el navegador hasta la base de datos al ejecutar `POST /movimientos-espontaneos`:

![Flujo](./../create_movimientos_client_flow_diagram.svg)

---

## Principios Arquitectónicos

### 1. Regla de Dependencia

Las dependencias apuntan **hacia adentro**. El dominio no importa nada de Laravel, Eloquent, ni de la capa de Aplicación:

```
Presentación → Aplicación → Dominio
Infraestructura → implementa contratos del Dominio
```

### 2. Inversión de Control (DIP)

El `StoreMovimientoHandler` recibe `MovimientoRepositoryContract` (contrato de dominio), no `EloquentMovimientoRepository` (implementación). El contenedor IoC de Laravel resuelve la implementación concreta en tiempo de ejecución.

### 3. Inmutabilidad de Agregados

Los agregados (`Categoria`, `Cuenta`, `Presupuesto`, etc.) son declarados `final readonly` o usan métodos que retornan nuevas instancias. Esto garantiza que los estados intermedios no se filtren y que las invariantes se apliquen en cada operación.

Unicamente los agregados que emiten eventos de dominio, no son `readonly`, pues deben usar el trait de `RecordsEvents` que tiene la responsabilidad de manejar los eventos de dominio.

### 4. Separación de Escritura y Lectura (CQRS)

- **Escritura**: `CommandBus → Handler → Aggregate → Repository (Eloquent)`.
- **Lectura**: `QueryBus → Handler → QueryExecutor (Eloquent directo)`. Los ejecutores de consulta devuelven DTOs, no agregados.

### 5. Transaccionalidad

Los comandos que implementan `TransactionalCommandContract` (p. ej., `StoreMovimientoCommand`) se envuelven automáticamente en transacciones de base de datos mediante `LaravelTransactionMiddleware`, garantizando atomicidad.

---

## Estructura de Directorios Clave

```
app/
├── Domains/          # Lógica de negocio pura
│   ├── Movimiento/
│   ├── Cuenta/
│   ├── Presupuesto/
│   └── ...
├── Application/      # Casos de uso (Commands, Queries, EventHandlers)
│   ├── Movimiento/
│   │   ├── Commands/
│   │   ├── Queries/
│   │   └── EventHandlers/
│   └── ...
├── Infrastructure/   # Implementaciones concretas
│   ├── Movimiento/
│   │   ├── Persistence/Repositories/
│   │   └── Queries/Executors/
│   └── ...
├── Http/             # Entrada HTTP
│   ├── Controllers/
│   ├── Requests/
│   └── Resources/
└── Shared/           # Abstracciones reutilizables
    ├── Domain/
    ├── Application/
    └── Infrastructure/
```

---

## Contexto del Proyecto

Leo Counter fue construido en memoria de **Leonardo Villamil Gamba**. Es una plataforma de código abierto, licenciada bajo MIT, diseñada para uso privado con datos financieros sensibles. La privacidad absoluta (sin telemetría, sin dependencias de terceros en producción para datos sensibles) es un requisito no funcional de primer nivel.
