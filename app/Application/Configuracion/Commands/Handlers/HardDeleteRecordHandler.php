<?php

namespace App\Application\Configuracion\Commands\Handlers;

use App\Application\Configuracion\Commands\HardDeleteRecordCommand;
use App\Application\Configuracion\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;

/**
 * Handler que orquesta la eliminación definitiva de un registro eliminado.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class HardDeleteRecordHandler
{
    public function __construct(
        private SoftDeleteManagerResolver $manager,
    ) {
    }

    public function __invoke(HardDeleteRecordCommand $command): void
    {
        $manager = $this->manager->resolve($command->domain);
        $record = $manager->findWithTrashed($command->id);

        if ($record === null) {
            throw new \LogicException('No se encontro el registro');
        }

        $manager->hardDelete($record->getId());
    }
}
