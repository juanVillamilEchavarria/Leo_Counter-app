<?php

namespace App\Domains\Cuenta\Repositories\Contracts;

use App\Models\Cuenta\Cuenta;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CuentaReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function whereAttr(string $attribute, $value): Builder;
    public function getRecordsCount(): int;
    public function getAllWithDetails(): Collection;
    public function getAllWithDetailsWhere(array $wheres): Collection;
    public function getWithDetails(Cuenta $cuenta);
}
