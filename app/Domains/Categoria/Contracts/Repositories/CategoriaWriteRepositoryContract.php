<?php

namespace App\Domains\Categoria\Contracts\Repositories;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\DTOs\DTOContract;
use App\Shared\Contracts\Repositories\SoftDeleteWriteRepositoryContract;
/**
 * Contrato de implementación de repositorio de escritura para el modelo Categoria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Contracts\Repositories
 * @since 1.0.0 
 * @version 1.0.0
 */
interface CategoriaWriteRepositoryContract extends SoftDeleteWriteRepositoryContract
{
    /**
     * Guardar un nuevo registro
     * @param DTOContract $storeCategoriaDTO
     * @return Model
     */
    public function store(DTOContract $storeCategoriaDTO): Model;
    /**
     * Actualizar un registro existente
     * @param Model $categoria
     * @param DTOContract $updateCategoriaDTO
     * @return bool
     */
    public function update(Model $categoria, DTOContract $updateCategoriaDTO): bool;
    /**
     * Eliminar un registro existente
     * @param Model $categoria
     * @return bool
     */
    public function destroy(Model $categoria): bool;
    /**
     * Alterna el valor de un atributo booleano
     * @param Model $categoria
     * @return bool
     */
    public function toggle(Model $categoria, string $attribute): bool;
}
