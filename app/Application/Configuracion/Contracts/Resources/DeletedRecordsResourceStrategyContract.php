<?php

namespace App\Application\Configuracion\Contracts\Resources;

use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Shared\Domain\Contracts\CollectionContract;
use Illuminate\Http\Resources\Json\JsonResource;

interface DeletedRecordsResourceStrategyContract
{
    public function supports(SoftDeleteManagerTypes $type): bool;
    public function makeResource(CollectionContract $data): JsonResource;
}
