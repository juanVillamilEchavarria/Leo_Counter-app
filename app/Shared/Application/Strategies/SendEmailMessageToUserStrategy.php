<?php

namespace App\Shared\Application\Strategies;

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
        private  EmailFormatBuilderContract $emailFormatBuilderContract,
        private  UsuarioCanBeNotifiedByAChannelCheckerContract $usuarioCanBeNotifiedByAChannelCheckerContract,
        private  CanalRepositoryContract $canalRepositoryContract,
        private  EmailServiceContract $emailServiceContract
    )
    {
    }
    public function supports(Usuario $usuario): bool
    {
       $canal = $this->canalRepositoryContract->findByName(CanalesNotificacionEnum::EMAIL->value);
       return $canal->isActive() && $this->usuarioCanBeNotifiedByAChannelCheckerContract->checkIfUsuarioCanBeNotifiedByAChannel($usuario, $canal);
    }

    /**
     * @inheritDoc
     */
    public function sendMessage(EventContract $event, Usuario $usuario): void
    {
        $emailMessage = $this->emailFormatBuilderContract->build($event, $usuario);
        try {
            $this->emailServiceContract->sendEmail($emailMessage);
        }catch (\Throwable $throwable){

            throw new CannotSendEmailMessageToUserException('no se pudo enviar el correo al usuario: '. $throwable->getMessage());
        }

    }
}
