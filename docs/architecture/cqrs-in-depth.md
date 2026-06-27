# CQRS en Profundidad — Leo Counter

Este documento explica la implementación detallada del patrón CQRS en Leo Counter, con ejemplos de código reales extraídos del proyecto.

---

## Principio Fundamental

CQRS (Command Query Responsibility Segregation) separa las operaciones de **escritura** (Commands) de las de **lectura** (Queries). En Leo Counter esto se aplica de forma estricta:

```
Escritura: HTTP Request → Controller → CommandBus → Handler → Aggregate → Repository
Lectura:   HTTP Request → Controller → QueryBus   → Handler → QueryExecutor → DTO
```

---

## CommandBus

### Contrato

```php
// app/Shared/Application/Contracts/Bus/CommandBus.php
interface CommandBus
{
    public function dispatch($command): mixed;
}
```

### Implementación Laravel

```php
// app/Shared/Infrastructure/Framework/Laravel/Buses/LaravelCommandBus.php
class LaravelCommandBus implements CommandBus
{
    public function __construct(private Dispatcher $dispatcher) {}

    public function dispatch($command): mixed
    {
        return $this->dispatcher->dispatch($command);
    }
}
```

La implementación delega en `Illuminate\Contracts\Bus\Dispatcher`, que resuelve el Handler correspondiente mediante el sistema de Jobs de Laravel. Los Commands **no son Jobs en cola**; se despachan de forma síncrona salvo indicación contraria.

### Middleware Transaccional

Los comandos que implementan `TransactionalCommandContract` se envuelven automáticamente en transacciones de base de datos:

```php
// app/Shared/Infrastructure/Framework/Laravel/Middlewares/LaravelTransactionMiddleware.php
final readonly class LaravelTransactionMiddleware
{
    public function handle(object $command, Closure $next): mixed
    {
        if ($command instanceof TransactionalCommandContract) {
            return DB::transaction(fn() => $next($command));
        }
        return $next($command);
    }
}
```

---

## QueryBus

### Contrato

```php
// app/Shared/Application/Contracts/Bus/QueryBus.php
interface QueryBus
{
    public function ask($query): mixed;
}
```

### Implementación

```php
final class LaravelQueryBus implements QueryBus
{
    public function __construct(
        private readonly Application $app
        ) {}

    public function ask(QueryContract $query): mixed
    {
        $handlerClass = $this->resolveHandlerClass($query);
        
        if (!class_exists($handlerClass)) {
            throw new \RuntimeException(
                "Handler {$handlerClass} no encontrado para el query " . get_class($query)
            );
        }
        $handler = $this->app->make($handlerClass);
        return $handler($query);
    }

    private function resolveHandlerClass(QueryContract $query): string
    {
        $queryClass = get_class($query);
        $pos = strrpos($queryClass, '\\');
        $namespace = substr($queryClass, 0, $pos);
        $className = substr($queryClass, $pos + 1);
        $handlerClass = $namespace . '\Handlers\\' . str_replace('Query', 'Handler', $className);
        return $handlerClass;
    }
}
```

---

## EventBus

### Contrato

```php
// app/Shared/Application/Contracts/Bus/EventBus.php
interface EventBus
{
    public function publish(EventContract $event): void;
    public function publishMany(array $events): void;
}
```

### Implementación

```php
class LaravelEventBus implements EventBus
{
    public function __construct(private \Illuminate\Contracts\Events\Dispatcher $eventDispatcher) {}

    public function publish(EventContract $event): void
    {
        try {
            $this->eventDispatcher->dispatch($event);
        } catch (DomainException $th) {
            throw $th; // Las excepciones de dominio se re-lanzan para rollback
        }
    }

    public function publishMany(array $events): void
    {
        foreach ($events as $event) {
            $this->publish($event);
        }
    }
}
```

---

## Anatomía de un Command

### Command Abstracto Base

```php
// app/Application/Movimiento/Commands/Abstracts/WriteMovimientoCommand.php
abstract readonly class WriteMovimientoCommand
{
    public function __construct(
        public string  $nombre,
        public string  $cuenta_id,
        public string  $categoria_id,
        public int     $tipo_movimiento_id,
        public float   $monto,
        public array   $comprobantes,
        public ?string $descripcion = null,
        public ?string $movimiento_pendiente_id = null,
    ) {}
}
```

### Command Concreto

```php
// app/Application/Movimiento/Commands/StoreMovimientoCommand.php
final readonly class StoreMovimientoCommand
    extends WriteMovimientoCommand
    implements TransactionalCommandContract
{
    // Sin propiedades adicionales; solo hereda el contrato transaccional
}
```

**Nota:** La herencia abstracta evita duplicación entre `StoreMovimientoCommand` y otros comandos de escritura similares.

---

## Anatomía de un Handler de Comando

```php
// app/Application/Movimiento/Commands/Handlers/StoreMovimientoHandler.php
final readonly class StoreMovimientoHandler
{
    public function __construct(
        private IdGeneratorContract          $idGenerator,
        private EventBus                     $eventBus,
        private MovimientoRepositoryContract $movimientoRepository
    ) {}

    public function __invoke(StoreMovimientoCommand $command): void
    {
        // 1. Construir el agregado (valida invariantes, graba domain event)
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $command->nombre,
            cuenta_id: new CuentaId($command->cuenta_id),
            categoria_id: new CategoriaId($command->categoria_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            monto: new Amount($command->monto),
            fecha: new Date(new DateTimeImmutable()),
            descripcion: $command->descripcion
        );

        // 2. Persistir (el repositorio publica los domain events)
        $this->movimientoRepository->store($movimiento);

        // 3. Publicar eventos de aplicación (cross-cutting)
        $this->eventBus->publish(new AttachmentsForMovimientoCreated(
            movimiento: $movimiento,
            comprobantes: $command->comprobantes
        ));
        $this->eventBus->publish(new AuditableActionOcurred(
            old_aggregate: null,
            new_aggregate: $movimiento,
            type: AuditableTypes::MOVIMIENTOS,
            action: AuditableActions::CREATE
        ));
    }
}
```

**Responsabilidades del Handler:**
1. Construir el agregado con Value Objects tipados.
2. Invocar el repositorio para persistir.
3. Publicar eventos de aplicación (auditoría, archivos, notificaciones).

**Lo que el Handler NO hace:**
- Lógica de negocio (está en el Agregado).
- Consultas de lectura (están en los QueryExecutors).
- Acceso directo a Eloquent (está en el Repositorio).

---

## Anatomía de una Query

```php
// app/Application/MovimientoFijo/Queries/ListAllMovimientoFijoQuery.php
final readonly class ListAllMovimientoFijoQuery implements ListMovimientoFijoQueryContract
{
    // parametros que pueda tener el query
    //ejemplo filtros, ordenamiento y paginación genérica
}
```

---

## Anatomía de un Handler de Query

```php
// app/Application/MovimientoFijo/Queries/Handlers/ListAllMovimientoFijoHandler.php
final readonly class ListAllMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoQueryExecutorContract $queryExecutor
    ) {}

    public function __invoke(ListAllMovimientoFijoQuery $query): CollectionContract
    {
        return $this->queryExecutor->execute($query);
    }
}
```

El Handler de Query delega completamente en el `QueryExecutor`. No hay lógica adicional.

---

## Query Executors

Los Query Executors viven en la capa de Infraestructura y usan Eloquent directamente para proyecciones optimizadas:

```php
// Patrón típico
final readonly class EloquentListAllMovimientoFijoWithDetailsExecutor implements MovimientoFijoQueryExecutorContract
{
    public function execute(ListMovimientoFijoQueryContract $query): CollectionContract
    {
        return LaravelCollection::make(
            MovimientoFijo::with([
                'categoria',
                'cuenta',
                'tipo_movimiento',
                'frecuencia_movimiento',
            ])->get()
        );
    }
}
```


---

## Resumen: Tipos de Handlers y sus Responsabilidades

| Tipo | Responsabilidad | Retorna |
|------|----------------|---------|
| Command Handler | Orquesta agregado + repositorio + eventos | `void` (o `mixed`) |
| Query Handler | Delega en QueryExecutor | `PaginatedTableResultDTO`,DTO específico, o `CollectionContract` |
| Event Handler | Efecto secundario de un evento | `void` |

---

## Convención de Nombres

| Artefacto | Ejemplo | Sufijo |
|-----------|---------|--------|
| Command | `StoreMovimientoCommand` | `Command` |
| Command Handler | `StoreMovimientoHandler` | `Handler` |
| Query | `ListAllMovimientoFijoQuery` | `Query` |
| Query Handler | `ListAllMovimientoFijoHandler` | `Handler` |
| Query Executor Contract | `MovimientoFijoQueryExecutorContract` | `QueryExecutorContract` |
| Event Handler | `MovimientoCreatedFinancialImpactEventHandler` | `EventHandler` |
