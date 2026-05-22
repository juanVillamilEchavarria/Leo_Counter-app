<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\StoreSuscriptorNotificacionCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Shared\Domain\Contracts\IdGeneratorContract;

final readonly class StoreSuscriptorNotificacionHandler
{
    public function __construct(
        private SuscriptorNotificacionRepositoryContract $repository,
        private SuscriptorUniquenessCheckerContract $checker,
        private IdGeneratorContract $idGenerator
    ){}

    public function __invoke(StoreSuscriptorNotificacionCommand $command)
    {
        $id = SuscriptorNotificacionId::generate($this->idGenerator);
        $usuarioId = new UsuarioId($command->user_id);
        $canalId = new CanalNotificacionId($command->canal_notificacion_id);

        $suscriptor = \App\Domains\Notificacion\Aggregates\SuscriptorNotificacion::create(
            id: $id,
            userId: $usuarioId,
            canalNotificacionId: $canalId,
            checker: $this->checker
        );

        return $this->repository->store($suscriptor);
    }
}
