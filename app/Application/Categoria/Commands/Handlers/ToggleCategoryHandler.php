<?php

namespace App\Application\Categoria\Commands\Handlers;

use App\Application\Categoria\Commands\ToggleCategoryCommand;
use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;

final readonly class ToggleCategoryHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository
    )
    {
    }

    public function __invoke(ToggleCategoryCommand $command) : bool
    {
        $result= $this->repository->toggle(new CategoriaId($command->id), $command->attribute);
        return $result !== true ? throw new CannotFindCategoriaException() : $result;
    }
}