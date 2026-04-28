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
    /**
     * Alterna el valor de un atributo booleano
     * @param int $id El ID de la categoría a la que se le va a alternar el valor del atributo
     * @param string $attribute El nombre del atributo booleano a alternar
     * @return bool
     */
    public function toggle(int $id, string $attribute): bool;
    /**
     * Busca una categoría por su ID
     * @param int $id El ID de la categoría a buscar
     * @return Categoria|null La categoría encontrada o null si no se encuentra ninguna categoría con el ID proporcionado
     */
    public function findById(int $id): ?Categoria;
}
