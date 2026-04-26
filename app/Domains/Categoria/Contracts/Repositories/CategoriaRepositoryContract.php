<?php

namespace App\Domains\Categoria\Contracts\Repositories;

use App\Domains\Categoria\Aggregates\Categoria;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Contracts\Repositories\SoftDeleteRepositoryContract;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Contrato de implementación de repositorio de escritura para el modelo Categoria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Contracts\Repositories
 * @since 1.0.0 
 * @version 1.0.0
 */
interface CategoriaRepositoryContract extends SoftDeleteRepositoryContract
{
    /**
     * Guardar un nuevo registro
     * @param Categoria $categoria
     * @return Model
     */
    public function store(object $categoria): AggregateModelContract;
    /**
     * Actualizar un registro existente
     * @param Model $categoria
     * @param DTOContract $updateCategoriaDTO
     * @return bool
     */
    public function update(object $categoria, int $id): bool;
    /**
     * Eliminar un registro existente
     * @param Model $categoria
     * @return bool
     */
    public function destroy(int $id): bool;
    // /**
    //  * Alterna el valor de un atributo booleano
    //  * @param Model $categoria
    //  * @return bool
    //  */
    // public function toggle(Model $categoria, string $attribute): bool;

    public function findById(int $id): ?Categoria;
}
