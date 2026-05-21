<?php

namespace App\Infrastructure\Configuracion\Resources;

use App\Application\Configuracion\Contracts\Resources\DeletedRecordsResourceStrategyContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Configuracion\SoftDeletesManagers\Cuenta\DeletedCuentasResource;

final readonly class DeletedCuentaRecordsResourceStrategy implements DeletedRecordsResourceStrategyContract
{
    public function supports(SoftDeleteManagerTypes $type): bool
    {
        return $type === SoftDeleteManagerTypes::CUENTAS;
    }

    public function makeResource(CollectionContract $data): JsonResource
    {
        return DeletedCuentasResource::collection($data);
    }
}
