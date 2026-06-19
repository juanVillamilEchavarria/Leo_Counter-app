<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Infrastructure\Transferencia\Queries\Executors\Eloquent;

use App\Application\Transferencia\Contracts\Queries\Executors\TransferenciaQueryExecutorContract;
use App\Models\Transferencia\Transferencia;
use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Infrastructure\Framework\Laravel\Collections\LaravelCollection;

/**
 * Ejecutor de consulta de transferencias usando Eloquent.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class EloquentListTransferenciasExecutor implements TransferenciaQueryExecutorContract
{
    public function execute(): CollectionContract
    {
        return LaravelCollection::make(
            Transferencia::with([
                'cuentaEnviadora:id,nombre',
                'cuentaReceptora:id,nombre'
            ])->orderByDesc('fecha')->get()
        );
    }
}
