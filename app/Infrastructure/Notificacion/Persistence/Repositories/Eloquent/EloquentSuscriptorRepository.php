<?php

namespace App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent;

use App\Shared\Domain\ValueObjects\Date;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorRepositoryContract;
use App\Models\Notificacion\SuscriptorNotificacion as SuscriptorModel;
use App\Domains\Notificacion\Aggregates\Suscriptor as SuscriptorAggregate;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;

final class EloquentSuscriptorRepository extends EloquentRepository implements SuscriptorRepositoryContract
{
    protected array $toggeable = ['activo'];

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof SuscriptorAggregate);

        return [
            'id' => $aggregate->getId()->getValue(),
            'user_id' => $aggregate->getUserId()->getValue(),
            'canal_notificacion_id' => $aggregate->getCanalNotificacionId()->getValue(),
            'active' => $aggregate->isActive(),
            'verified_at'=> $aggregate->getVerifiedAt()?->format()
        ];
    }

    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return SuscriptorAggregate::reconstitute(
            id: new SuscriptorId($model->id),
            userId: new UsuarioId($model->user_id),
            canalNotificacionId: new CanalId($model->canal_notificacion_id),
            verified_at: $model->verified_at ? new Date(new \DateTimeImmutable($model->verified_at)) : null,
            activo: $model->active ?? true,
        );
    }

    public function __construct()
    {
        parent::__construct(SuscriptorModel::class);
    }
}
