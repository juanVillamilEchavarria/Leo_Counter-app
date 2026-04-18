<?php

namespace App\Domains\Movimiento\Contracts\Repositories;

use App\Models\Movimiento\Movimiento;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MovimientoReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function getRecordsCount(): int;
    public function getEspontaneoRecordsCount(): int;
    public function getAllWithDetails(): Collection;
    public function getAllWithDetailsWhere(array $wheres): Collection;
    public function getWithDetails(Movimiento $movimiento);
}