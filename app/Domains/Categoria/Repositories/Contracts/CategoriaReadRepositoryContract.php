<?php

namespace App\Domains\Categoria\Repositories\Contracts;

use App\Shared\DTOs\Querys\TableQueryDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
/**
 * Contrato de implementación de repositorio de lectura para el modelo Categoria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Repositories\Contracts
 * @since 1.0.0
 */
interface CategoriaReadRepositoryContract {
       /**
     * Retorna un listado paginado según los filtros establecidos.
     */
    public function paginate(TableQueryDTO $dto, array $initialWheres = []): LengthAwarePaginator;

    /**
     * Busca una categoría por su ID.
     * @return Categoria|null
     */
    public function find(int $id);

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
