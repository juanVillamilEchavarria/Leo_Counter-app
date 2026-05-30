<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Notificacion\Persistence\Repositories\Eloquent;

use App\Models\Notificacion\CanalNotificacion;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use App\Domains\Notificacion\Contracts\Repositories\CanalRepositoryContract;
use App\Models\Notificacion\CanalNotificacion as CanalModel;
use App\Domains\Notificacion\Aggregates\Canal as CanalAggregate;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use Illuminate\Database\Eloquent\Model;

final  class EloquentCanalRepository extends EloquentRepository implements CanalRepositoryContract
{
    protected array $toggeable = ['active'];

    protected function mapAggregateToAttributes(object $aggregate): array
    {
        assert($aggregate instanceof CanalAggregate);

        return [
            'id' => $aggregate->getId()->getValue(),
            'nombre' => $aggregate->getNombre(),
            'active' => $aggregate->isActive()
        ];
    }

    /**
     * @param Model $model
     * @return CanalAggregate
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        return CanalAggregate::reconstitute(
            id: new CanalId($model->id),
            nombre: $model->nombre,
            activo: $model->active ?? true
        );
    }
    public function findByName(string $name): ?CanalAggregate
    {
        $model = CanalNotificacion::where('nombre', $name)->first();
        return $model ? $this->mapDatabaseRecordToAggregate($model) : null;
    }

    public function __construct()
    {
        parent::__construct(CanalModel::class);
    }
}
