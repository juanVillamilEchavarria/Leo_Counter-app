<?php

namespace App\Domains\MovimientoPendiente\Repositories\Contracts;

use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface MovimientoPendienteReadRepositoryContract extends SoftDeleteReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function whereAttr(string $attribute, $value);
    public function getRecordsCount(): int;
    public function getAll(): Collection;
    public function getWithDetails(Model $movimientoPendiente);
    public function getAvailableRecordsCount(): int;
}
