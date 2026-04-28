<?php

namespace App\Application\Categoria\Commands\Handlers;

use App\Application\Categoria\Commands\ToggleCategoryCommand;
use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;

final readonly class ToggleCategoryHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository
    )
    {
    }

    public function __invoke(ToggleCategoryCommand $command) : bool
    {
        $result= $this->repository->toggle($command->id, $command->attribute);
        return $result !== true ? throw new CannotFindCategoriaException() : $result;
    }
}