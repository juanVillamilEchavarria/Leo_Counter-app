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
use App\Application\Categoria\Queries\GetCategoriaForEditQuery;
use App\Application\Categoria\DTOs\CategoriaForEditDTO;
use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Domains\Categoria\ValueObjects\CategoriaId;

/**
 * Handler encargado de procesar el query GetCategoriaForEditQuery, que tiene la responsabilidad de obtener los datos necesarios para editar una categoría específica.
 * Este handler interactúa con el repositorio de categorías para recuperar la información de la categoría identificada por su ID, y luego transforma esa información en un DTO que será utilizado para llenar el formulario de edición.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class GetCategoriaForEditHandler
{
    public function __construct(
        private CategoriaRepositoryContract $categoriaRepository
    )
    {
    }

    /**
     * Obtiene los datos necesarios para editar una categoría específica.
     * @param GetCategoriaForEditQuery $query El query que contiene el ID de la categoría a editar.
     * @return CategoriaForEditDTO Un DTO que contiene la información de la categoría para ser editada.
     * @throws CannotFindCategoriaException Si no se encuentra la categoría con el ID proporcionado.
     */
    public function __invoke(GetCategoriaForEditQuery $query): CategoriaForEditDTO
    {
        $categoria = $this->categoriaRepository->findById(new CategoriaId($query->id));
        if(!$categoria){
            throw new CannotFindCategoriaException();
        }
        assert($categoria instanceof \App\Domains\Categoria\Aggregates\Categoria);

        return new CategoriaForEditDTO(
            id: $query->id,
            nombre: $categoria->getNombre(),
            tipo_movimiento_id: $categoria->getTipoMovimientoId(),
            descripcion: $categoria->getDescripcion()
        );
    }
}
