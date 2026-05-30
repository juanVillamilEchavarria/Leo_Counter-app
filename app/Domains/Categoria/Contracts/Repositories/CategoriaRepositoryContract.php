<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Categoria\Contracts\Repositories;

use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\Contracts\SoftDeleteRepositoryContract;

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
     * @param AggregateModelContract $categoria
     * @return AggregateModelContract
     */
    public function store(AggregateModelContract $categoria): AggregateModelContract;

    /**
     * Actualizar un registro existente
     * @param AggregateModelContract $categoria
     * @return bool
     */
    public function update(AggregateModelContract $categoria): bool;

    /**
     * Eliminar un registro existente
     * @param AggregateModelIdContract $id
     * @return bool
     */
    public function destroy(AggregateModelIdContract $id): bool;

    /**
     * Alterna el valor de un atributo booleano
     * @param AggregateModelIdContract $id El ID de la categoría a la que se le va a alternar el valor del atributo
     * @param string $attribute El nombre del atributo booleano a alternar
     * @return bool
     */
    public function toggle(AggregateModelIdContract $id, string $attribute): bool;

    /**
     * Busca una categoría por su ID
     * @param AggregateModelIdContract $id El ID de la categoría a buscar
     * @return AggregateModelContract|null La categoría encontrada o null si no se encuentra ninguna categoría con el ID proporcionado
     */
    public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
