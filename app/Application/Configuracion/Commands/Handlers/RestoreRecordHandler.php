<?php

namespace App\Application\Configuracion\Commands\Handlers;
use App\Application\Configuracion\Commands\RestoreRecordCommand;
use App\Application\Configuracion\Resolvers\SoftDeleteManagerResolver;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
final readonly class RestoreRecordHandler
{
    public function __construct(
        private SoftDeleteManagerResolver $manager
    )
    {
    }
    public function __invoke(RestoreRecordCommand $command): void
    {
        $manager = $this->manager->resolve($command->domain);
        $record = $manager->findWithTrashed($command->id);
        if($record === null){
            throw new \LogicException('No se encontro el registro');
        }
        $manager->restore($record->getId());
    }

}
