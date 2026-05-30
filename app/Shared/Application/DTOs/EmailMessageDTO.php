<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
