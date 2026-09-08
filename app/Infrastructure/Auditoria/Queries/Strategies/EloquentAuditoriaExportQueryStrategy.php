<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Auditoria\Queries\Strategies;

use App\Application\Exportacion\Contracts\Queries\Strategies\ExportQueryStrategyContract;
use App\Domains\Exportacion\Enums\ExportableTable;
use App\Infrastructure\Auditoria\Queries\Executors\Eloquent\EloquentAuditoriaPaginatedTableQueryExecutor;
use App\Infrastructure\Exportacion\Queries\Executors\Eloquent\Abstract\EloquentExportDataQuery;
use App\Models\Auditoria\Auditoria;
use Illuminate\Database\Eloquent\Model;
use Override;

/**
 * Estrategia Eloquent de exportación para la tabla de auditorías (server-side).
 * Inyecta por composición el executor paginado existente, sin extenderlo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class EloquentAuditoriaExportQueryStrategy extends EloquentExportDataQuery implements ExportQueryStrategyContract
{
    public function __construct(
        private EloquentAuditoriaPaginatedTableQueryExecutor $paginatedExecutor
    ) {
        parent::__construct($paginatedExecutor);
    }

    #[Override]
    public function supports(ExportableTable $table): bool
    {
        return $table === ExportableTable::AUDITORIAS;
    }

    /**
     * @return array<string>
     */
    protected function getHeaders(): array
    {
        return ['Fecha', 'Usuario', 'Tipo Auditable', 'ID Auditable', 'Acción', 'Valores Anteriores', 'Valores Nuevos'];
    }

    /**
     * @param  Auditoria  $auditoria
     * @return array<string, mixed>
     */
    protected function toRow(Model $auditoria): array
    {
        return [
            'Fecha' => $auditoria->created_at,
            'Usuario' => $auditoria->usuario?->name ?? 'N/A',
            'Tipo Auditable' => $auditoria->auditable_type?->value ?? $auditoria->auditable_type ?? 'N/A',
            'ID Auditable' => $auditoria->auditable_id ?? 'N/A',
            'Acción' => $auditoria->action?->value ?? $auditoria->action ?? 'N/A',
            'Valores Anteriores' => $this->formatValues($auditoria->old_values),
            'Valores Nuevos' => $this->formatValues($auditoria->new_values),
        ];
    }

    /**
     * @param  mixed  $values
     */
    private function formatValues($values): string
    {
        if ($values === null) {
            return '';
        }

        return is_array($values) ? json_encode($values, JSON_UNESCAPED_UNICODE) : (string) $values;
    }
}
