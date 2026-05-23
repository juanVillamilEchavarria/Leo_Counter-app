<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\StoreSuscriptorCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\Notificacion\Events\SuscriptorCreated;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

final readonly class StoreSuscriptorHandler
{
    public function __construct(
        private SuscriptorNotificacionRepositoryContract $repository,
        private UsuarioRepositoryContract $usuarioRepositoryContract,
        private SuscriptorUniquenessCheckerContract $checker,
        private EventBus $eventBus,
        private IdGeneratorContract $idGenerator
    ){}

    public function __invoke(StoreSuscriptorCommand $command) : string
    {
        $id = SuscriptorId::generate($this->idGenerator);
        $usuarioId = new UsuarioId($command->user_id);
        $canalId = new CanalId($command->canal_notificacion_id);

        $suscriptor = \App\Domains\Notificacion\Aggregates\Suscriptor::create(
            id: $id,
            userId: $usuarioId,
            canalNotificacionId: $canalId,
            checker: $this->checker
        );
        $usuario = $this->usuarioRepositoryContract->findById($usuarioId);

         $registro =$this->repository->store($suscriptor);
         $this->eventBus->publish(new SuscriptorCreated(
             suscriptor:$suscriptor,
             usuario: $usuario,
             date:  new Date(new DateTimeImmutable()))
         );
         return $registro->getId()->getValue();
    }
}
