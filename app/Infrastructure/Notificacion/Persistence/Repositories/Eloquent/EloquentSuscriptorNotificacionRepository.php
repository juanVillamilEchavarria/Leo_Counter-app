<?php

namespace App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent;

use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Models\Notificacion\SuscriptorNotificacion as SuscriptorModel;
use App\Domains\Notificacion\Aggregates\SuscriptorNotificacion as SuscriptorAggregate;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;

final class EloquentSuscriptorNotificacionRepository extends EloquentRepository implements SuscriptorNotificacionRepositoryContract
{
    protected array $toggeable = ['activo'];

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof SuscriptorAggregate);

        return [
            'id' => $aggregate->getId()->getValue(),
            'user_id' => $aggregate->getUserId()->getValue(),
            'canal_notificacion_id' => $aggregate->getCanalNotificacionId()->getValue(),
            'activo' => $aggregate->isActivo()
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return SuscriptorAggregate::reconstitute(
            id: new SuscriptorNotificacionId($model->id),
            userId: new UsuarioId($model->user_id),
            canalNotificacionId: new CanalNotificacionId($model->canal_notificacion_id),
            activo: $model->activo ?? true
        );
    }

    public function __construct()
    {
        parent::__construct(SuscriptorModel::class);
    }
}
