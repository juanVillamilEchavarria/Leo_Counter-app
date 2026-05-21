<?php

namespace App\Infrastructure\Configuracion\Resources;

use App\Application\Configuracion\Contracts\Resources\DeletedRecordsResourceStrategyContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Configuracion\SoftDeletesManagers\Presupuesto\DeletedPresupuestosResource;

final readonly class DeletedPresupuestoRecordsResourceStrategy implements DeletedRecordsResourceStrategyContract
{
    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::PRESUPUESTOS;
    }

    public function makeResource(CollectionContract $data): JsonResource
    {
        return DeletedPresupuestosResource::collection($data);
    }
}
