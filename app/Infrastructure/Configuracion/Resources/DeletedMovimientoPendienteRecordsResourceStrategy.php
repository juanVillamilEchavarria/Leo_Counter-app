<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Infrastructure\Configuracion\Resources;

use App\Application\Configuracion\Contracts\Resources\DeletedRecordsResourceStrategyContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Configuracion\SoftDeletesManagers\MovimientoPendiente\DeletedMovimientoPendientesResource;

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
