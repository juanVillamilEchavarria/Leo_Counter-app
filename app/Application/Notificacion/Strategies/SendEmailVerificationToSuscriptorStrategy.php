<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Strategies;

use App\Application\Notificacion\Contracts\Strategies\SendVerificationToSuscriptorStrategyContract;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Shared\Application\Contracts\Services\EmailServiceContract;
use App\Application\Notificacion\Contracts\Builders\SendVerificationToSuscriptorFormatBuilderContract;
use App\Domains\Notificacion\Enums\CanalesNotificacionEnum;
use App\Domains\Notificacion\Contracts\Repositories\CanalRepositoryContract;
use App\Application\Notificacion\Exceptions\CannotSendEmailVerificationToSuscriptorException;

/**
 * Estrategia para el envio de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendEmailVerificationToSuscriptorStrategy implements SendVerificationToSuscriptorStrategyContract
{
    public function __construct(
        private EmailServiceContract                              $emailService,
        private SendVerificationToSuscriptorFormatBuilderContract $builder,
        private CanalRepositoryContract $canalRepository

    )
    {
    }

    /**
     * @inheritDoc
     */
    public function supports(SendVerificationToSuscriptorEventContract $event): bool
    {
        $canal = $this->canalRepository->findById($event->getSuscriptor()->getCanalNotificacionId());
        return $canal !== null && $canal->getNombre() === CanalesNotificacionEnum::EMAIL->value;
    }

    /**
     * @inheritDoc
     */
    public function sendVerification(SendVerificationToSuscriptorEventContract $event): void
    {
        $emailMessage = $this->builder->create($event);
        try {
            $this->emailService->sendEmail($emailMessage);

        }catch (\Throwable $exception){

            throw new CannotSendEmailVerificationToSuscriptorException('No se No se pudo enviar el correo de verificacion al suscriptor. '.$exception->getMessage(), $exception->getCode(), $exception);

        }

    }
}
