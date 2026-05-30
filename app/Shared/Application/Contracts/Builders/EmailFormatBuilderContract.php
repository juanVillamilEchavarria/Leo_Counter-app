<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Builders;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Domain\Contracts\EventContract;

/**
 * Contrato que deben implementar los builders de formato de un email, para poder ser usado por las estrategias compartidas de envio de email.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Builders
 * @since 1.0.0
 * @version 1.0.0
 */
interface EmailFormatBuilderContract
{
    /**
     * Construye el formato del email
     * @param EventContract $event
     * @return EmailMessageDTO
     */
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO;

    /**
     * Indica si el builder soporta el evento proporcionado.
     *
     * @param EventContract $event
     * @return bool
     */
    public function supports(EventContract $event): bool;
}
