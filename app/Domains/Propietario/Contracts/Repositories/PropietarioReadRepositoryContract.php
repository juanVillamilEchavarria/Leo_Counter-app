<?php

namespace App\Domains\Propietario\Contracts\Repositories;

use App\Models\Propietario\Propietario;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PropietarioReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function whereAttr(string $attribute, $value);
    public function getRecordsCount(): int;
    public function getAll(): Collection;
    public function getAllWithFullDetails(): Collection;
}
