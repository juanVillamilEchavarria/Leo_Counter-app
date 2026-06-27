# Clean Architecture: Detalle de Capas — Leo Counter

Este documento describe en detalle cada capa de la arquitectura de Leo Counter, con ejemplos de clases reales extraídas del código fuente.

---

## Diagrama de Capas

<p align="center">
  <img src="./../clean_architecture.svg" alt="Diagrama de Arquitectura Leo Counter" width="800">
</p>


---

## Capa de Dominio (`app/Domains/`)

Es el corazón del sistema. Contiene la lógica de negocio pura, **sin dependencias** de Laravel, Eloquent, ni ningún framework.

### Agregados

Los agregados son clases `final` con constructor `private`. Se instancian únicamente mediante métodos de fábrica estáticos:

```php
// app/Domains/Movimiento/Aggregates/Movimiento.php
final class Movimiento implements PrimitiveAggregateModelContract
{
    use RecordsEvents;

    private function __construct(
        private MovimientoId           $id,
        private string                 $nombre,
        private CuentaId               $cuenta_id,
        private CategoriaId            $categoria_id,
        private TipoMovimientoEnum     $tipo_movimiento_id,
        private ?MovimientoPendienteId $movimiento_pendiente_id,
        private Amount                 $monto,
        private Date                   $fecha,
        private ?string                $descripcion,
    ) {}

    // Crea y graba evento de dominio
    public static function create(...): self
    {
        self::validateData($nombre, $monto, CannotExecuteMovimientoTransactionException::class);
        $movimiento = new self(...);
        $movimiento->recordThat(new MovimientoCreated($movimiento));
        return $movimiento;
    }

    // Rehidrata sin validaciones ni eventos
    public static function reconstitute(...): self
    {
        return new self(...);
    }
}
```

**Principio clave:** `create()` aplica invariantes y publica eventos. `reconstitute()` solo rehidrata desde la persistencia.

### Value Objects

Son inmutables (`final readonly`). Todos los identificadores extienden `DomainId`:

```php
// app/Shared/Domain/ValueObjects/Abstracts/DomainId.php
abstract readonly class DomainId implements AggregateModelIdContract
{
    public function __construct(private string $id) {}

    public static function generate(IdGeneratorContract $idGenerator): static
    {
        return new static($idGenerator->generate()); // UUID v7
    }

    public function getValue(): string { return $this->id; }
    public function equals(self $other): bool { return $this->id === $other->id; }
}
```

**VOs compartidos en `Shared/Domain/ValueObjects/`:**

| VO | Propósito | Invariante clave |
|----|-----------|-----------------|
| `Amount` | Valor monetario | Almacena en centavos (int); no puede ser negativo |
| `Date` | Fecha de dominio | Envuelve `DateTimeImmutable` |
| `Email` | Dirección de correo | Valida formato |
| `Password` | Contraseña | Mantiene hash |
| `JsonPayload` | Payload JSON (auditorías) | Serialización segura |

**VOs específicos de módulo:**

| VO | Módulo | Nota |
|----|--------|------|
| `CuentaId` | Cuenta | UUID v7 |
| `MovimientoId` | Movimiento | UUID v7 |
| `MovimientoFijoId` | MovimientoFijo | UUID v7 |
| `MovimientoPendienteId` | MovimientoPendiente | UUID v7 |
| `TransferenciaId` | Transferencia | UUID v7 |
| `PresupuestoId` | Presupuesto | UUID v7 |
| `CategoriaId` | Categoria | UUID v7 |
| `PropietarioId` | Propietario | UUID v7 |
| `UsuarioId` | Usuario | UUID v7 |
| `AuditoriaId` | Auditoria | UUID v7 |
| `CanalId` | Notificacion | UUID v7 |
| `SuscriptorId` | Notificacion | UUID v7 |

### Eventos de Dominio

```php
// app/Domains/Movimiento/Events/MovimientoCreated.php
final readonly class MovimientoCreated implements FinancialMovimientoRegisteredEventContract, MovimientoEventContract
{
    public function __construct(
        private Movimiento $movimiento,
        private Date $fecha = new Date(new \DateTimeImmutable())
    )
    {
    }
    public function ocurredOn(): Date
    {
       return $this->fecha;
    }

    public function getMovimiento(): Movimiento
    {
        return $this->movimiento;
    }

}

```

Los eventos se graban en el agregado mediante `recordThat()` y son liberados por el repositorio post-persistencia mediante `releaseEvents()`.

### Contratos de Dominio

Los contratos son interfaces que definen lo que el dominio espera de la infraestructura.


```php
// app/Domains/Movimiento/Contracts/Repositories/MovimientoRepositoryContract.php
interface MovimientoRepositoryContract
{
    public function store(Movimiento $movimiento): void;
    public function findById(MovimientoId $id): Movimiento;
    public function update(Movimiento $movimiento): void;
    public function delete(Movimiento $movimiento): void;
}
```

---

## Capa de Aplicación (`app/Application/`)

Orquesta los casos de uso. No contiene lógica de negocio; delega en el dominio.

### Commands y Handlers

```php
// Comando: DTO de escritura (inmutable)
final readonly class StoreMovimientoCommand extends WriteMovimientoCommand
    implements TransactionalCommandContract
{
    // Hereda: nombre, cuenta_id, categoria_id, tipo_movimiento_id,
    //         monto, comprobantes, descripcion, movimiento_pendiente_id
}

// Handler: orquesta dominio + repositorio + eventos
final readonly class StoreMovimientoHandler
{
    public function __construct(
        private IdGeneratorContract $idGenerator,
        private EventBus $eventBus,
        private MovimientoRepositoryContract $movimientoRepository
    ) {}

    public function __invoke(StoreMovimientoCommand $command): void
    {
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
        $this->movimientoRepository->store($movimiento); // persiste + publica domain events
        $this->eventBus->publish(new AttachmentsForMovimientoCreated(...));
        $this->eventBus->publish(new AuditableActionOcurred(...));
    }
}
```

### Queries y Query Executors

```php
// Query: DTO de lectura
final readonly class ListAllMovimientoFijoQuery implements QueryContract
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
        public readonly ?string $search,
    ) {}
}

// Handler: delega en QueryExecutor de infraestructura
final readonly class ListAllMovimientoFijoHandler
{
    public function __invoke(ListAllMovimientoFijoQuery $query): PaginatedTableResultDTO
    {
        return $this->queryExecutor->execute($query);
    }
}
```

### DTOs

Los DTOs (`MovimientoEditDTO`, `MovimientoFormOptionsDTO`, `MovimientoShowDTO`, etc.) son objetos de transferencia de datos entre la capa de Aplicación y la de Presentación. No contienen lógica de negocio.

### EventHandlers de Aplicación

```php
// app/Application/Movimiento/EventHandlers/MovimientoCreatedFinancialImpactEventHandler.php
final readonly class MovimientoCreatedFinancialImpactEventHandler
{
    public function __invoke(FinancialMovimientoRegisteredEventContract $event): void
    {
        $movimiento = $event->getMovimiento();
        $cuenta = $this->cuentaRepository->findById($movimiento->getCuentaId());
        $this->transactionValidatorResolver->resolve($cuenta, $movimiento);
        $cuenta = $this->applyTransactionEffectForCuentaResolver->resolve($movimiento, $cuenta);
        $this->cuentaRepository->update($cuenta);
    }
}
```

---

## Capa de Infraestructura (`app/Infrastructure/` + `app/Shared/Infrastructure/`)

Contiene las implementaciones concretas de los contratos de dominio y aplicación.

### Repositorios Eloquent

Los repositorios Eloquent implementan los contratos de repositorio de dominio. Son los únicos puntos donde se usa Eloquent directamente para escritura


```php
// Patrón típico de repositorio
final class EloquentMovimientoRepository implements MovimientoRepositoryContract
{
    public function store(Movimiento $movimiento): void
    {
        $this->model->create($movimiento->toPrimitive());
        $this->eventBus->publishMany($movimiento->releaseEvents());
    }

    public function findById(MovimientoId $id): Movimiento
    {
        $model = $this->model->findOrFail($id->getValue());
        return Movimiento::reconstitute(
            id: new MovimientoId($model->id),
            nombre: $model->nombre,
            // ...
        );
    }
}
```

### Query Executors

Para lecturas, los executors usan Eloquent directamente para proyecciones optimizadas (no hidratan agregados):

```php
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

### Buses Laravel

| Bus | Clase | Delegado en |
|-----|-------|-------------|
| `LaravelCommandBus` | `Illuminate\Contracts\Bus\Dispatcher` | `$dispatcher->dispatch($command)` |
| `LaravelQueryBus` | implementacion nativa de php y laravel | funciones internas |
| `LaravelEventBus` | `Illuminate\Contracts\Events\Dispatcher` | `$eventDispatcher->dispatch($event)` |

---

## Capa de Presentación (`app/Http/`)

Delega inmediatamente en el bus correspondiente y devuelve una respuesta Inertia.

```php
// app/Http/Controllers/Movimiento/MovimientoEspontaneoController.php
public function store(StoreMovimientoRequest $request): RedirectResponse
{
    $this->commandBus->dispatch(new StoreMovimientoCommand(
        nombre: $request->nombre,
        cuenta_id: $request->cuenta_id,
        // ...
    ));
    Inertia::flash('success','Movimiento creado con exito');
    return redirect()->route('movimientosEspontaneos.index');
}
```

Los `FormRequest` de Laravel (`StoreMovimientoRequest`) validan la entrada HTTP antes de que llegue al bus.

---

## Regla de Oro: Dirección de Dependencias


**Nunca** debe existir un import de clases de frameworks o librerias dentro de `app/Domains/` o `app/Application/`.
