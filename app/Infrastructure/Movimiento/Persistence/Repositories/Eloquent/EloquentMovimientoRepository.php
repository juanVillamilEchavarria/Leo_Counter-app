<?php
namespace App\Infrastructure\Movimiento\Persistence\Repositories\Eloquent;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Shared\Domain\Contracts\AggregateModelContract;
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
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof MovimientoAggregate);
       return [
            'id'=> $aggregate->getId()->getValue(),
            'nombre'=> $aggregate->getNombre(),
            'cuenta_id'=> $aggregate->getCuentaId()->getValue(),
            'categoria_id'=> $aggregate->getCategoriaId()->getValue(),
            'tipo_movimiento_id'=> $aggregate->getTipoMovimientoId(),
            'movimiento_pendiente_id'=> $aggregate->getMovimientoPendienteId()?->getValue(),
            'monto'=> $aggregate->getMonto(),
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
           tipo_movimiento_id: $model->tipo_movimiento_id,
           monto: $model->monto,
           movimiento_pendiente_id: $model->movimiento_pendiente_id,
           descripcion: $model->descripcion,
           fecha: new Date(new \DateTimeImmutable($model->fecha))

       );
    }
    public function __construct()
    {
        parent::__construct(Movimiento::class);
    }
}
