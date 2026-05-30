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

use App\Domains\Categoria\Aggregates\Categoria;
use App\Application\Categoria\Commands\StoreCategoryCommand;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
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
        private CategoriaUniquenessCheckerContract $uniquenessChecker,
        private IdGeneratorContract $idGenerator
    )
    {
    }

    public function __invoke(StoreCategoryCommand $command)
    {
        $categoria = Categoria::create(
            id: CategoriaId::generate($this->idGenerator),
            nombre: $command->nombre,
            tipo_movimiento_id: $command->tipo_movimiento_id,
            descripcion: $command->descripcion,
            checker: $this->uniquenessChecker
        );
        return $this->repository->store($categoria);
    }
}