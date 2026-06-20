<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Configuracion\Strategies;

use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Http\Resources\Configuracion\SoftDeletesManagers\MovimientoPendiente\DeletedMovimientoPendientesResource;
use App\Infrastructure\Configuracion\Contracts\DeletedRecordsResourceStrategyContract;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;

final readonly class DeletedMovimientoPendienteRecordsResourceStrategy implements DeletedRecordsResourceStrategyContract
{
    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::MOVIMIENTOS_PENDIENTES;
    }

    public function makeResource(CollectionContract $data): JsonResource
    {
        return DeletedMovimientoPendientesResource::collection($data);
    }
}
