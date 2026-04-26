<?php

namespace App\Application\Categoria\Commands\Handlers;

use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Application\Categoria\Commands\UpdateCategoryCommand;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
/**
 * Handler para el comando de actualización de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateCategoryHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository,
        private CategoriaUniquenessCheckerContract $uniquenessChecker
    )
    {
    }

    public function __invoke(UpdateCategoryCommand $command)
    {
        $existing = $this->repository->findById($command->id);
        if(!$existing){
            throw new CannotFindCategoriaException();
        }
        $categoria = $existing->updateData(
            nombre: $command->nombre,
            tipo_movimiento_id: $command->tipo_movimiento_id,
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker,
            id: $command->id
        );
        return $this->repository->update($categoria, $command->id);
    }
}