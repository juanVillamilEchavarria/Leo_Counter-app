<?php

namespace App\Application\Categoria\Commands\Handlers;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Application\Categoria\Commands\StoreCategoryCommand;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;

/**
 * Handler para el comando de creación de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreCategoryHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository,
        private CategoriaUniquenessCheckerContract $uniquenessChecker
    )
    {
    }

    public function __invoke(StoreCategoryCommand $command)
    {
        $categoria = Categoria::create(
            nombre: $command->nombre,
            tipo_movimiento_id: $command->tipo_movimiento_id,
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker
        );
        return $this->repository->store($categoria);
    }
}