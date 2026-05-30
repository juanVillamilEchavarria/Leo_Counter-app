<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoFijo\Commands\Handlers;

use App\Application\MovimientoFijo\Commands\ToggleMovimientoFijoCommand;
use App\Domains\MovimientoFijo\Contracts\Repositories\MovimientoFijoRepositoryContract;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;

/**
 * Handler del comando ToggleMovimientoFijoCommand.
 * Delega en el repositorio el alternado de atributos booleanos permitidos.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ToggleMovimientoFijoHandler
{
    public function __construct(
        private MovimientoFijoRepositoryContract $repository,
    ) {
    }

    public function __invoke(ToggleMovimientoFijoCommand $command): bool
    {
        return $this->repository->toggle(new MovimientoFijoId($command->id), $command->attribute);
    }
}
