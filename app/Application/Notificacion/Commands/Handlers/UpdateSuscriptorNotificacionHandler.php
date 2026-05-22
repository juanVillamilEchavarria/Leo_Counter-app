<?php

namespace App\Application\Notificacion\Commands\Handlers;

use App\Application\Notificacion\Commands\UpdateSuscriptorNotificacionCommand;
use App\Domains\Notificacion\Contracts\Repositories\SuscriptorNotificacionRepositoryContract;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Domains\Notificacion\Exceptions\SuscriptorNotificacionNotFoundException;
use App\Domains\Notificacion\Exceptions\CannotUpdateSuscriptorNotificacionException;

final readonly class UpdateSuscriptorNotificacionHandler
{
    public function __construct(
        private SuscriptorNotificacionRepositoryContract $repository,
        private SuscriptorUniquenessCheckerContract $checker
    ){}

    public function __invoke(UpdateSuscriptorNotificacionCommand $command): bool
    {
        $existing = $this->repository->findById(new SuscriptorNotificacionId($command->id));
        if (!$existing) {
            throw new SuscriptorNotificacionNotFoundException();
        }

        if ($this->checker->exists($command->user_id, $command->canal_notificacion_id, $command->id)) {
            throw new CannotUpdateSuscriptorNotificacionException(message: 'Ya existe otra suscripción con esos valores');
        }

        $updated = \App\Domains\Notificacion\Aggregates\SuscriptorNotificacion::reconstitute(
            id: new SuscriptorNotificacionId($command->id),
            userId: new UsuarioId($command->user_id),
            canalNotificacionId: new CanalNotificacionId($command->canal_notificacion_id),
            activo: $existing->isActivo()
        );

        return $this->repository->update($updated);
    }
}
