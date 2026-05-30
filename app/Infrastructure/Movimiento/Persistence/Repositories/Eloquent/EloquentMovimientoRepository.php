<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Models\Movimiento\Movimiento;
use App\Domains\Movimiento\Aggregates\Movimiento as MovimientoAggregate;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Implementacion del repositorio de movimiento usando eloquent ORM.
 *
 * @package App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class EloquentMovimientoRepository extends EloquentRepository implements MovimientoRepositoryContract
{
    public function __construct(
        private EventBus $eventBus
    )
    {
        parent::__construct(Movimiento::class);
    }

    public function store(AggregateModelContract $model): AggregateModelContract
    {
        $events = [];
        if (method_exists($model, 'releaseEvents')) {
            $events = $model->releaseEvents();
        }
        $stored = parent::store($model);

        if (!empty($events)) {
            $this->eventBus->publishMany($events);
        }

        return $stored;
    }

    public function destroy(AggregateModelIdContract $id): bool
    {
       $model = ($this->model)::find($id->getValue());
       if(!$model) return false;
        $aggregate = $this->mapDatabaseRecordToAggregate($model);
        $deletedAggregate = $aggregate->delete();

        $model->delete();
        $this->eventBus->publishMany($deletedAggregate->releaseEvents());
        return true;
    }

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof MovimientoAggregate);
       return [
            'id'=> $aggregate->getId()->getValue(),
            'nombre'=> $aggregate->getNombre(),
            'cuenta_id'=> $aggregate->getCuentaId()->getValue(),
            'categoria_id'=> $aggregate->getCategoriaId()->getValue(),
            'tipo_movimiento_id'=> $aggregate->getTipoMovimientoId()->value,
            'movimiento_pendiente_id'=> $aggregate->getMovimientoPendienteId()?->getValue(),
            'monto'=> $aggregate->getMonto()->getValue(),
            'fecha'=> $aggregate->getFecha()->format(),
            'descripcion'=> $aggregate->getDescripcion(),
        ];
    }
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
       return MovimientoAggregate::reconstitute(
           id: new MovimientoId($model->id),
           nombre: $model->nombre,
           cuenta_id: new CuentaId($model->cuenta_id),
           categoria_id: new CategoriaId($model->categoria_id),
           tipo_movimiento_id: TipoMovimientoEnum::try($model->tipo_movimiento_id),
           monto: new Amount($model->monto),
           fecha: new Date(new \DateTimeImmutable($model->fecha)),
           descripcion: $model->descripcion,
           movimiento_pendiente_id: $model->movimiento_pendiente_id ? new MovimientoPendienteId($model->movimiento_pendiente_id) : null

       );
    }
}
