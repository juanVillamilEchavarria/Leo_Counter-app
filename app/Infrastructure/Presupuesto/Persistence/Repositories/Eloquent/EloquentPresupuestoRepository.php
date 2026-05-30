<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Presupuesto\Persistence\Repositories\Eloquent;

use App\Domains\Presupuesto\Aggregates\Presupuesto as PresupuestoAggregate;
use App\Domains\Presupuesto\Contracts\Repositories\PresupuestoRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Models\Presupuesto\Presupuesto;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use Carbon\Carbon;
use DateTimeImmutable;

final class EloquentPresupuestoRepository extends EloquentRepository implements PresupuestoRepositoryContract
{
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof PresupuestoAggregate, 'El agregado debe ser una instancia de PresupuestoAggregate');

        return [
            'id' => $aggregate->getId()->getValue(),
            'categoria_id' => $aggregate->getCategoriaId()->getValue(),
            'monto' => $aggregate->getMonto()->getValue(),
            'periodo' => $aggregate->getPeriodo()->format('Y-m'),
            'descripcion' => $aggregate->getDescripcion(),
            'user_id' => $aggregate->getUserId()->getValue(),
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return PresupuestoAggregate::reconstitute(
            id: new PresupuestoId($model->id),
            categoria_id: new CategoriaId($model->categoria_id),
            monto: new Amount($model->monto),
            periodo: new Date(new DateTimeImmutable($model->periodo)),
            descripcion: $model->descripcion,
            user_id: new UsuarioId($model->user_id),
        );
    }

    public function __construct()
    {
        parent::__construct(Presupuesto::class);
    }
}
