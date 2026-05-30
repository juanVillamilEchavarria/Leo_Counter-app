<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Contracts\Builders;
use App\Domains\Notificacion\Contracts\Events\SendVerificationToSuscriptorEventContract;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Contrato para el constructor de la notificacion de verificacion de correo electronico al suscriptor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface SendVerificationToSuscriptorFormatBuilderContract
{
    /**
     * Crea el formato de la notificacion de verificacion de correo electronico al suscriptor
     * @param SendVerificationToSuscriptorEventContract $event
     * @return EmailMessageDTO
     */
    public function create(SendVerificationToSuscriptorEventContract $event): EmailMessageDTO;

}
