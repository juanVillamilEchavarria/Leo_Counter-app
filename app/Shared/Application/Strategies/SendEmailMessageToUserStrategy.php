<?php

namespace App\Shared\Application\Strategies;

use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Notificacion\Enums\CanalesNotificacionEnum;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\Exceptions\CannotSendEmailMessageToUserException;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\Contracts\SendMessageToUserByChannelStrategyContract;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\Contracts\Services\EmailServiceContract;
use App\Shared\Domain\Contracts\Checkers\UsuarioCanBeNotifiedByAChannelCheckerContract;
use App\Domains\Notificacion\Contracts\Repositories\CanalRepositoryContract;

/**
 * Estrategia de envio de email a un usuario
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendEmailMessageToUserStrategy implements SendMessageToUserByChannelStrategyContract
{
    public function __construct(
        private iterable $emailFormatBuilders,
        private  UsuarioCanBeNotifiedByAChannelCheckerContract $usuarioCanBeNotifiedByAChannelCheckerContract,
        private  CanalRepositoryContract $canalRepositoryContract,
        private  EmailServiceContract $emailServiceContract
    )
    {
    }
    public function getChanel(): Canal
    {
       return $this->canalRepositoryContract->findByName(CanalesNotificacionEnum::EMAIL->value);
    }

    public function supports(Usuario $usuario): bool
    {

        $canal = $this->getChanel();
        if (!$canal) {
            return false;
        }
        return $this->usuarioCanBeNotifiedByAChannelCheckerContract->checkIfUsuarioCanBeNotifiedByAChannel($usuario, $canal);
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(EventContract $event, Usuario $usuario): void
    {
        $builder = $this->resolveBuilder($event);
        $emailMessage = $builder->build($event, $usuario);
        try {
            $this->emailServiceContract->sendEmail($emailMessage);
        } catch (\Throwable $throwable) {

            throw new CannotSendEmailMessageToUserException('no se pudo enviar el correo al usuario: '. $throwable->getMessage());
        }

    }

    /**
     * Resuelve el builder adecuado para un evento dado.
     *
     * @param EventContract $event
     * @return EmailFormatBuilderContract
     * @throws \RuntimeException Si no se encuentra un builder soportado para el evento.
     */
    private function resolveBuilder(EventContract $event): EmailFormatBuilderContract
    {
        foreach ($this->emailFormatBuilders as $builder) {
            if ($builder instanceof EmailFormatBuilderContract && $builder->supports($event)) {
                return $builder;
            }
        }

        throw new \RuntimeException('No builder found for event: ' . get_class($event));
    }
}
