<?php

namespace App\Domains\Categoria\Contracts\Repositories;

use App\Models\Categoria\Categoria;
use App\Shared\Domain\ValueObjects\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Contracts\Repositories\SoftDeleteReadRepositoryContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Contrato de implementación de repositorio de lectura para el modelo Categoria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Contracts\Repositories
 * @since 1.0.0
 */
interface CategoriaReadRepositoryContract extends SoftDeleteReadRepositoryContract {
       /**
     * Retorna un listado paginado según los filtros establecidos.
     */
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;


    /**
     * Aplica múltiples condiciones a la consulta.
     * @return Builder<Categoria>
     */
    public function where(array $wheres): Builder;

    /**
     * Aplica una condición específica a la consulta.
     * @return Builder<Categoria>
     */
    public function whereAttr(string $attribute, $value): Builder;

    /**
     * Retorna el número total de registros.
     * @return int
     */
    public function getRecordsCount(): int;

    /**
     * Obtiene categorías filtradas por tipo de movimiento.
     * @return Collection<Categoria>
     */
    public function getForOptionsByTipoMovimiento(TipoMovimientoEnum $tipo_movimiento): Collection;

    /**
     * Obtiene todas las categorías.
     * @return Collection<Categoria>
     */
    public function getAll(): Collection;

    /**
     * Obtiene una categoría por su id.
     * @return ?Categoria
     */
    public function find(int $id): ?Model;

    /**
     * Obtiene todas las categorías por tipo de movimiento.
     * @return Collection<Categoria>
     */
    public function getAllByType(int $tipo_movimiento_id): Collection;

    /**
     * Obtiene categorías cuyo nombre coincide con el buscado.
     * @return Collection<Categoria>
     */
    public function getEqual(string $nombre, int $tipo_movimiento_id): Builder;

    /**
     * Obtiene todas las categorías con relaciones cargadas.
     * @return Collection<Categoria>
     */
    public function getAllWithFullDetails(): Collection;
}
