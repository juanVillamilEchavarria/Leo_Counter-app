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

use App\Application\Categoria\Commands\ToggleCategoriaCommand;
use App\Application\Categoria\Exceptions\CannotFindCategoriaException;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;

final readonly class ToggleCategoriaHandler{
    public function __construct(
        private CategoriaRepositoryContract $repository
    )
    {
    }

    public function __invoke(ToggleCategoriaCommand $command) : bool
    {
        $result= $this->repository->toggle(new CategoriaId($command->id), $command->attribute);
        return $result !== true ? throw new CannotFindCategoriaException() : $result;
    }
}
