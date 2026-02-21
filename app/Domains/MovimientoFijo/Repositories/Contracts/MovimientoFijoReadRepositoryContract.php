<?php

namespace App\Domains\MovimientoFijo\Repositories\Contracts;

use App\Models\MovimientoFijo\MovimientoFijo;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MovimientoFijoReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function whereAttr(string $attribute, $value);
    public function getRecordsCount(): int;
    public function getAll(): Collection;
    public function getAllWithDetails(): Collection;
}
