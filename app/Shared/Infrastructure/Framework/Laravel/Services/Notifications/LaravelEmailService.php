<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\Services\Notifications;

use App\Shared\Application\Contracts\Services\EmailServiceContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use Illuminate\Support\Facades\Mail;

/**
 * Servicio de envio de correo electronico de laravel
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class LaravelEmailService implements EmailServiceContract
{

    /**
     * @inheritDoc
     */
    public function sendEmail(EmailMessageDTO $message): void
    {
        Mail::html($message->htmlBody, function ($mail) use ($message) {
            $mail->to($message->to)
                ->subject($message->subject);
        });

    }
}
