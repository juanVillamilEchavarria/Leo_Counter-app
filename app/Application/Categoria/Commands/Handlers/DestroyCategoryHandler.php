<?php

namespace App\Application\Categoria\Commands\Handlers;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Application\Categoria\Commands\DestroyCategoryCommand;
use App\Domains\Categoria\ValueObjects\CategoriaId;

/**
 * Handler para el comando de eliminación de categorías.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroyCategoryHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository
    )
    {
    }

    public function __invoke(DestroyCategoryCommand $command)
    {
        return $this->repository->destroy(new CategoriaId($command->id));
    }
}