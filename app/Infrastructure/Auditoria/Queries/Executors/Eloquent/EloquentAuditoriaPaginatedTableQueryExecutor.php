<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Auditoria\Queries\Executors\Eloquent;

use App\Shared\Infrastructure\Queries\Executors\EloquentPaginatedTableQueryExecutor;
use App\Application\Auditoria\Contracts\Queries\Executors\AuditoriaPaginatedTableQueryExecutorContract;
use App\Models\Auditoria\Auditoria;
use Override;

/**
 * Executor Eloquent para paginación de tabla de auditorías (server side).
 * Basado en el patrón compartido de EloquentPaginatedTableQueryExecutor.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
final readonly class EloquentAuditoriaPaginatedTableQueryExecutor extends EloquentPaginatedTableQueryExecutor implements AuditoriaPaginatedTableQueryExecutorContract
{
    #[Override]
    protected function model(): string
    {
       return Auditoria::class;
    }

    #[Override]
    protected function modelRelations(): array
    {
        return ['usuario'];
    }

    #[Override]
    protected function searchColumns(): array
    {
        return [
            'usuario' => [
                'users.name'
            ],
            'auditable_type',
            'action',
            'auditable_id'
        ];
    }

    #[Override]
    protected function modelSorteableRelations(): array
    {
        return [
            'usuario'=>[
                'relation'=> 'usuario',
                'column'=> 'users.name'
            ]
        ];
    }
}
