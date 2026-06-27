# ADR-0004: Diseño basado en Dominios (DDD)

- **Estado:** Aceptada
- **Fecha:** 2026-06-04
- **Autores:** Juan Esteban Villamil Echavarria

---

## Contexto

Leo Counter abarca múltiples contextos de negocio que tienen vida propia: Cuentas, Movimientos, Presupuestos, Transferencias, Notificaciones, etc. Sin una estructura clara, el código tiende hacia un modelo anémico donde los controladores concentran toda la lógica, los modelos Eloquent se convierten en objetos de datos planos y las reglas de negocio se dispersan en servicios genéricos.

El objetivo es que Leo Counter sea mantenible a largo plazo y que las reglas de negocio sean claras, testeables y localizables.

## Decisión

Se adopta **Domain-Driven Design (DDD)** como base de la organización del código, aplicado dentro de la arquitectura de capas de Clean Architecture:

### Estructura de capas

```
app/
├── Domains/          ← CAPA DE DOMINIO (entidades, VOs, eventos, contratos)
├── Application/      ← CAPA DE APLICACIÓN (Commands, Queries, Handlers, DTOs)
├── Infrastructure/   ← CAPA DE INFRAESTRUCTURA (Eloquent, Buses, Services)
├── Http/             ← CAPA DE PRESENTACIÓN (Controllers, Requests, Resources)
└── Shared/           ← CAPA COMPARTIDA (abstracciones y contratos cross-cutting)
```

### Principios de organización

**1. Cada módulo de dominio es autónomo:**

```
app/Domains/Movimiento/
├── Aggregates/        ← Movimiento.php (lógica de negocio)
├── Contracts/         ← Interfaces de repositorios y estrategias
│   ├── Repositories/
│   ├── Events/
│   └── Strategies/
├── Events/            ← MovimientoCreated.php, MovimientoDeleted.php
├── Exceptions/        ← CannotDeleteMovimientoException.php, etc.
├── Strategies/        ← ApplyGastoEffectForCuentaStrategy.php, etc.
└── ValueObjects/      ← MovimientoId.php
```

**2. Los agregados son siempre clases `final` con constructor privado:**

Los agregados exponen exactamente tres métodos de creación:
- `create()`: valida invariantes y graba eventos de dominio.
- `reconstitute()`: rehidrata desde persistencia sin validaciones.
- `updateData()` (o variantes): modifica el estado aplicando invariantes específicas del caso de uso.

**3. Los Value Objects son inmutables (`final readonly`):**

Todos los identificadores heredan de `DomainId` (UUID v7). Los VOs compartidos (`Amount`, `Date`, `Email`, `Password`) viven en `Shared/Domain/ValueObjects/`.

**4. Las reglas de negocio viven en el dominio, no en la Aplicación:**

Los checker contracts (`PropietarioHasCuentasCheckerContract`, `PresupuestoUniquenessCheckerContract`) son abstracciones de dominio cuya implementación vive en Infraestructura.

**5. La Aplicación orquesta, el Dominio decide:**

```php
// ✅ Correcto: el agregado aplica la invariante
$presupuesto = Presupuesto::create($id, $categoriaId, $monto, $periodo, $descripcion, $userId, $checker);

// ❌ Incorrecto: la invariante en el Handler
if ($presupuestoRepository->existsForCategoryAndPeriod($categoriaId, $periodo)) {
    throw new Exception('...');
}
```

### Módulos de dominio presentes

| Módulo | Namespace | Tipo de Agregado |
|--------|-----------|-----------------|
| Cuenta | `App\Domains\Cuenta` | `final readonly class Cuenta` |
| Movimiento | `App\Domains\Movimiento` | `final class Movimiento` (con RecordsEvents) |
| MovimientoFijo | `App\Domains\MovimientoFijo` | `final readonly class MovimientoFijo` |
| MovimientoPendiente | `App\Domains\MovimientoPendiente` | `final readonly class MovimientoPendiente` |
| Transferencia | `App\Domains\Transferencia` | `final class Transferencia` (con RecordsEvents) |
| Presupuesto | `App\Domains\Presupuesto` | `final readonly class Presupuesto` |
| Propietario | `App\Domains\Propietario` | `final class Propietario` |
| Usuario | `App\Domains\Usuario` | `final class Usuario` |
| Auditoria | `App\Domains\Auditoria` | `final readonly class Auditoria` |
| Categoria | `App\Domains\Categoria` | `final readonly class Categoria` |
| Notificacion | `App\Domains\Notificacion` | `Canal`, `Suscriptor` |
| Reporte | `App\Domains\Reporte` | VOs de resultado (sin persistencia directa) |

## Alternativas Consideradas

| Alternativa | Pros | Contras |
|-------------|------|---------|
| Arquitectura por funcionalidad (feature folders) | Navegación intuitiva para CRUD | Mezcla capas; dificulta testeo de dominio |
| Modelos Eloquent como entidades | Integración ORM directa | Acoplamiento a infraestructura; lógica de negocio dispersa |
| Microservicios | Escalabilidad independiente | Complejidad operativa excesiva para una app autoalojada |

## Consecuencias

**Positivas:**
- Las reglas de negocio (invariantes) son completamente testeables sin base de datos (`tests/Unit/Domain/`).
- El código de cada módulo es localizable: un cambio en Movimiento no requiere buscar en toda la base de código.
- Los contratos de repositorio (`MovimientoRepositoryContract`) permiten intercambiar la implementación de Infraestructura sin tocar el dominio.
- Cumplimiento explícito de SOLID: SRP (cada clase tiene un propósito), OCP (nuevos comportamientos vía estrategias), LSP (implementaciones cumplen contratos), ISP (contratos pequeños y específicos), DIP (el dominio no depende de Eloquent).

**Negativas / Trade-offs:**
- Mayor cantidad de archivos y carpetas comparado con un enfoque MVC tradicional.
- La curva de aprendizaje para un nuevo colaborador requiere entender el flujo completo de capas antes de hacer cambios.
- Algunos módulos simples (Propietario, Categoria) podrían haberse implementado con CRUD plano, pero se mantienen en DDD para consistencia arquitectónica.

## Referencias

- `app/Domains/` (todos los módulos)
- `app/Shared/Domain/Contracts/AggregateModelContract.php`
- `app/Shared/Domain/ValueObjects/Abstracts/DomainId.php`
- `tests/Unit/Domain/` (tests de agregados y VOs)
