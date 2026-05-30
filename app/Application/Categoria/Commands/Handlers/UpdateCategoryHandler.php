<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Categoria\Commands\Handlers;

use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Application\Categoria\Commands\UpdateCategoryCommand;
use App\Domains\Categoria\Aggregates\Categoria as CategoriaAggregate;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
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
        $existing = $this->repository->findById(new CategoriaId($command->id));
        if(!$existing){
            throw new CannotFindCategoriaException();
        }
        assert($existing instanceof CategoriaAggregate);
        $categoria = $existing->updateData(
            nombre: $command->nombre,
            tipo_movimiento_id: $command->tipo_movimiento_id,
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker
        );
        return $this->repository->update($categoria);
    }
}