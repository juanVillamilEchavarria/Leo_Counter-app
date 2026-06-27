# ADR-0001: Adopción de CQRS (Command Query Responsibility Segregation)

- **Estado:** Aceptada
- **Fecha:** 2026-06-01
- **Autores:** Juan Esteban Villamil Echavarria

---

## Contexto

Leo Counter maneja operaciones de escritura con efectos de dominio complejos (p. ej., registrar un movimiento impacta el saldo de una cuenta) y operaciones de lectura que requieren proyecciones con joins y filtros dinámicos (tablas paginadas con TanStack Table server-side, reportes financieros multi-dominio).

Usar un único modelo de repositorio para ambos casos genera las siguientes fricciones:
- Los repositorios de escritura necesitan hidratar agregados completos con Value Objects; los de lectura solo necesitan DTOs livianos.
- Los efectos de dominio (eventos, validadores) no deben dispararse en consultas de solo lectura.
- La lógica de negocio se mezclaría con las proyecciones optimizadas para UI.

## Decisión

Se adopta el patrón **CQRS** de manera explícita y sistemática en toda la capa de Aplicación:

- **Commands** (escritura): representan intenciones que modifican el estado. Cada comando tiene un único `Handler` que orquesta el agregado de dominio, su repositorio y el bus de eventos de aplicacion (caso de uso).
- **Queries** (lectura): representan preguntas sobre el estado actual. Cada query tiene un `Handler` que delega en un `QueryExecutor` (implementado en Infraestructura), el cual usa Eloquent directamente para proyecciones optimizadas.

### Buses implementados

| Bus | Contrato | Implementación |
|-----|----------|----------------|
| `CommandBus` | `App\Shared\Application\Contracts\Bus\CommandBus` | `LaravelCommandBus` (delega a `Illuminate\Contracts\Bus\Dispatcher`) |
| `QueryBus` | `App\Shared\Application\Contracts\Bus\QueryBus` | `LaravelQueryBus` |
| `EventBus` | `App\Shared\Application\Contracts\Bus\EventBus` | `LaravelEventBus` (delega a `Illuminate\Contracts\Events\Dispatcher`) |

### Ejemplo de Command y Handler

```php
// Comando: intención de escritura (sin lógica)
final readonly class StoreMovimientoCommand extends WriteMovimientoCommand
    implements TransactionalCommandContract {}

// Handler: orquesta agregado + repositorio + eventos
final readonly class StoreMovimientoHandler
{
    public function __invoke(StoreMovimientoCommand $command): void
    {
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $command->nombre,
            cuenta_id: new CuentaId($command->cuenta_id),
            // ...
        );
        $this->movimientoRepository->store($movimiento);
        $this->eventBus->publish(new AttachmentsForMovimientoCreated(...));
        $this->eventBus->publish(new AuditableActionOcurred(...));
    }
}
```

### Ejemplo de Query y QueryExecutor

```php
// Query: pregunta sin efectos
final readonly class ListAllMovimientoFijoQuery implements QueryContract {}

// Handler delega a ejecutor de infraestructura
final readonly class ListAllMovimientoFijoHandler
{
    public function __invoke(ListAllMovimientoFijoQuery $query): PaginatedTableResultDTO
    {
        return $this->queryExecutor->execute($query);
    }
}

// QueryExecutor: proyección Eloquent optimizada (sin hidratar agregados)
final class EloquentMovimientoFijoQueryExecutor implements MovimientoFijoQueryExecutorContract
{
    public function execute(ListMovimientoFijoQueryContract $query): PaginatedTableResultDTO { ... }
}
```

## Alternativas Consideradas

| Alternativa | Pros | Contras |
|-------------|------|---------|
| Repositorio único (CRUD) | Simplicidad inicial | Mezcla lógica de escritura y lectura; contamina el dominio con necesidades de UI |
| Event Sourcing completo | Trazabilidad total del estado | Complejidad excesiva para el alcance del proyecto; curva de aprendizaje muy alta |
| CQRS solo conceptual (sin buses) | Menor infraestructura | Pierde la capacidad de aplicar middleware transaccional y decoradores de forma uniforme |

## Consecuencias

**Positivas:**
- Cada caso de uso es un archivo PHP pequeño, cohesivo y testeable de forma aislada.
- Los comandos transaccionales (`TransactionalCommandContract`) se envuelven automáticamente en transacciones de base de datos mediante el `LaravelTransactionMiddleware`.
- Las queries pueden evolucionar con proyecciones SQL complejas sin afectar la integridad del dominio.
- Los `EventHandlers` (p. ej., `MovimientoCreatedFinancialImpactEventHandler`) se suscriben a eventos del bus sin acoplarse al handler de comando.

**Negativas / Trade-offs:**
- Mayor cantidad de clases por caso de uso (Command + Handler + Query + Handler + Executor + Contract).
- El desarrollador nuevo necesita entender el flujo completo antes de poder contribuir.

## Referencias

- `app/Shared/Infrastructure/Framework/Laravel/Buses/`
- `app/Application/Movimiento/Commands/`
- `app/Application/Movimiento/Queries/`
- `app/Shared/Infrastructure/Framework/Laravel/Middlewares/LaravelTransactionMiddleware.php`
