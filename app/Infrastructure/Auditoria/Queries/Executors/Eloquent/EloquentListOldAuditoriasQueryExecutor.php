<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Auditoria\Queries\Executors\Eloquent;

use App\Application\Auditoria\Contracts\Queries\Executors\ListOldAuditoriasQueryExecutorContract;
use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\ValueObjects\AuditableRegisterId;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Models\Auditoria\Auditoria as AuditoriaModel;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Domain\ValueObjects\JsonPayload;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;
use Override;

/**
 * Executor Eloquent que obtiene las auditorías con 6 meses o más de antigüedad
 * y las devuelve como una colección de agregados.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentListOldAuditoriasQueryExecutor implements ListOldAuditoriasQueryExecutorContract
{
    #[Override]
    public function execute(): CollectionContract
    {
        $records = AuditoriaModel::query()
            ->where('created_at', '<=', now()->subMonths(6))
            ->get();

        $aggregates = $records->map(fn (AuditoriaModel $record) => Auditoria::reconstitute(
            id: new AuditoriaId($record->id),
            user_id: new UsuarioId($record->user_id),
            auditable_type: $record->auditable_type instanceof AuditableTypes
                ? $record->auditable_type
                : AuditableTypes::from($record->auditable_type),
            auditable_id: new AuditableRegisterId($record->auditable_id),
            action: $record->action instanceof AuditableActions
                ? $record->action
                : AuditableActions::from($record->action),
            old_values: $this->toJsonPayload($record->old_values),
            new_values: $this->toJsonPayload($record->new_values),
        ));

        return new LaravelCollection($aggregates);
    }

    private function toJsonPayload(mixed $value): ?JsonPayload
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof JsonPayload) {
            return $value;
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);

            return new JsonPayload($decoded ?: []);
        }

        return new JsonPayload($value);
    }
}
