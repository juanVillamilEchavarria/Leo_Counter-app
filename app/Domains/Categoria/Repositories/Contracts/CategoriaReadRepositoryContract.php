<?php

namespace App\Domains\Categoria\Repositories\Contracts;

use App\Models\Categoria\Categoria;
use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;

interface CategoriaReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function find(int $id);
    public function where(array $wheres): Builder;
    public function getRecordsCount(): int;
    public function getForOptionsByTipoMovimiento(TipoMovimientoEnum $tipo_movimiento): Collection;
    public function getAll(): Collection;
    public function getAllByType(int $tipo_movimiento_id): Collection;
    public function getEqual(string $nombre, int $tipo_movimiento_id): Builder;
    public function getAllWithFullDetails(): Collection;
}
