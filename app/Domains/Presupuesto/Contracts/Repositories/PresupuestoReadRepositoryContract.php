<?php

namespace App\Domains\Presupuesto\Contracts\Repositories;

use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use App\Models\Presupuesto\Presupuesto;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PresupuestoReadRepositoryContract extends SoftDeleteReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function getRecordsCount(): int;
    public function getHistoricRecordsCount(): int;
    public function getMesActualRecordsCount(): int;
    public function getAllWithDetails(): Collection;
    public function getAllWithDetailsWhere(array $wheres): Collection;
    public function getWithDetails(Presupuesto $presupuesto);
    public function getEqualPresupuesto(int $categoria_id, \Carbon\Carbon | string $periodo): Builder;
}
