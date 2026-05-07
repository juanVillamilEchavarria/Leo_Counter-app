<?php

namespace App\Domains\Cuenta\Contracts\Repositories;

use App\Models\Cuenta\Cuenta;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Contrato de implementación de repositorio de lectura para el modelo Cuenta
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Cuenta\Contracts\Repositories
 * @since 1.0.0
 * @version 1.0.0
 */
interface CuentaReadRepositoryContract extends SoftDeleteReadRepositoryContract {
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;
    public function getAllDeleted(): Collection;
    public function where(array $wheres): Builder;
    public function find(string|int $id): ?Model;
    public function whereAttr(string $attribute, $value): Builder;
    public function getForOptions(): Collection;
    public function getRecordsCount(): int;
    public function getAllWithDetails(): Collection;
    public function getAllWithDetailsWhere(array $wheres): Collection;
    public function getWithDetails(Cuenta $cuenta);
}
