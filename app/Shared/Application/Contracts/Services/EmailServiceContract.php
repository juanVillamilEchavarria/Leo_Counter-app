<?php

namespace App\Shared\Application\Contracts\Services;
use App\Shared\Application\DTOs\EmailMessageDTO;
/**
 * Contrato para el servicio de envio de emails
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface EmailServiceContract
{
    /**
     * Envio de un email
     * @param EmailMessageDTO $message - el dto del email
     *@see EmailMessageDTO
     */
    public function sendEmail(EmailMessageDTO $message): void;

}
