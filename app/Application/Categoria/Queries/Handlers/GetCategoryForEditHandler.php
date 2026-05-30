<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Queries\Handlers;

use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Application\Categoria\Queries\GetCategoryForEditQuery;
use App\Application\Categoria\DTOs\CategoryForEditDTO;
use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Domains\Categoria\ValueObjects\CategoriaId;

/**
 * Handler encargado de procesar el query GetCategoryForEditQuery, que tiene la responsabilidad de obtener los datos necesarios para editar una categoría específica.
 * Este handler interactúa con el repositorio de categorías para recuperar la información de la categoría identificada por su ID, y luego transforma esa información en un DTO que será utilizado para llenar el formulario de edición.
 * 
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetCategoryForEditHandler
{
    public function __construct(
        private CategoriaRepositoryContract $categoriaRepository
    )
    {
    }

    /**
     * Obtiene los datos necesarios para editar una categoría específica.
     * @param GetCategoryForEditQuery $query El query que contiene el ID de la categoría a editar.
     * @return CategoryForEditDTO Un DTO que contiene la información de la categoría para ser editada.
     * @throws CannotFindCategoriaException Si no se encuentra la categoría con el ID proporcionado.
     */
    public function __invoke(GetCategoryForEditQuery $query): CategoryForEditDTO
    {
        $categoria = $this->categoriaRepository->findById(new CategoriaId($query->id));
        if(!$categoria){
            throw new CannotFindCategoriaException();
        }
        assert($categoria instanceof \App\Domains\Categoria\Aggregates\Categoria);

        return new CategoryForEditDTO(
            id: $query->id,
            nombre: $categoria->getNombre(),
            tipo_movimiento_id: $categoria->getTipoMovimientoId(),
            descripcion: $categoria->getDescripcion()
        );
    }
}