<?php

namespace App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Notificacion\Contracts\Repositories\CanalNotificacionRepositoryContract;
use App\Models\Notificacion\CanalNotificacion as CanalModel;
use App\Domains\Notificacion\Aggregates\CanalNotificacion as CanalAggregate;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;

final class EloquentCanalNotificacionRepository extends EloquentRepository implements CanalNotificacionRepositoryContract
{
    protected array $toggeable = ['activo'];

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof CanalAggregate);

        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'activo' => $aggregate->isActivo()
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return CanalAggregate::reconstitute(
            id: new CanalNotificacionId($model->id),
            nombre: $model->nombre,
            activo: $model->activo ?? true
        );
    }

    public function __construct()
    {
        parent::__construct(CanalModel::class);
    }
}
