<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Infrastructure\Auditoria\Persistence\Repositories;

use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Domains\Auditoria\Contracts\Repositories\AuditoriaRepositoryContract;
use App\Domains\Auditoria\ValueObjects\AuditableRegisterId;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Infrastructure\AbstractPersistence\Repositories\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Domain\ValueObjects\JsonPayload;

/**
 * Repositorio Eloquent de escritura para el agregado Auditoria.
 *  @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
final  class EloquentAuditoriaRepository extends EloquentRepository implements AuditoriaRepositoryContract
{
    /**
     * @param Auditoria $aggregate
     */
    protected function mapAggregateToAttributes(object $aggregate): array
    {
        return[
            'id'=> $aggregate->getId()->getValue(),
            'user_id'=> $aggregate->getUserId()->getValue(),
            'auditable_type'=> $aggregate->getAuditableType()->value,
            'auditable_id'=> $aggregate->getAuditableId()->getValue(),
            'action'=> $aggregate->getAction()->value,
            'old_values'=> $aggregate->getOldValues()->getValue(),
            'new_values'=> $aggregate->getNewValues()->getValue(),
        ];
    }

    /**
     * @param Model $model
     * @return Auditoria
     */
    protected function mapDatabaseRecordToAggregate(Model $model): AggregateModelContract
    {
        $oldValues = $model->old_values;
        $newValues = $model->new_values;

        // Normalizar a JsonPayload si es array o string
        if ($oldValues !== null && !($oldValues instanceof JsonPayload)) {
            if (is_string($oldValues)) {
                $decoded = json_decode($oldValues, true) ?: [];
                $oldValues = new JsonPayload($decoded);
            } elseif (is_array($oldValues)) {
                $oldValues = new JsonPayload($oldValues);
            }
        }

        if ($newValues !== null && !($newValues instanceof JsonPayload)) {
            if (is_string($newValues)) {
                $decoded = json_decode($newValues, true) ?: [];
                $newValues = new JsonPayload($decoded);
            } elseif (is_array($newValues)) {
                $newValues = new JsonPayload($newValues);
            }
        }

        return Auditoria::reconstitute(
            id: new AuditoriaId($model->id),
            user_id: new UsuarioId($model->user_id),
            auditable_type: $model->auditable_type,
            auditable_id: new AuditableRegisterId($model->auditable_id),
            action: $model->action,
            old_values: $oldValues,
            new_values: $newValues
        );
    }
}
