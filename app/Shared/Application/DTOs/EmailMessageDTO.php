<?php

namespace App\Shared\Application\DTOs;

use App\Shared\Domain\ValueObjects\Email;

/**
 * DTO para el envio de un email
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class EmailMessageDTO
{
    public function __construct(
        public Email $to,
        public string $subject,
        public string $htmlBody
    )
    {
    }

}
