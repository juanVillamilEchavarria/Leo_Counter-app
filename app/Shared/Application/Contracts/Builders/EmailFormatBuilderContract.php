<?php

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

}
