<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Commands\Handlers;

use App\Domains\Notificacion\Contracts\Repositories\SuscriptorRepositoryContract;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Application\Notificacion\Commands\VerifySuscriptorCommand;
use App\Domains\Notificacion\Events\SuscriptorVerified;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\ValueObjects\Date;

final readonly class VerifySuscriptorHandler
{
    public function __construct(
        private SuscriptorRepositoryContract $repository,
        private EventBus                     $eventBus
    )
    {
    }
    public function __invoke(VerifySuscriptorCommand $command): void
    {
        $suscriptor = $this->repository->findById(new SuscriptorId($command->id));
        $suscriptorVerified = $suscriptor->verify();
        $this->repository->update($suscriptorVerified);
        $this->eventBus->publish(new SuscriptorVerified(
            suscriptor:  $suscriptorVerified,
            date: new Date(new \DateTimeImmutable())
        ));
    }

}
