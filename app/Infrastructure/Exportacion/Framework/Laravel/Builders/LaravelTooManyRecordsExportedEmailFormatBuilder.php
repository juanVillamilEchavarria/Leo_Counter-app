<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Framework\Laravel\Builders;

use App\Application\Exportacion\Events\TooManyRecordsExported;
use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Repositories\UsuarioRepositoryContract;
use App\Shared\Application\Contracts\Builders\EmailFormatBuilderContract;
use App\Shared\Application\DTOs\EmailMessageDTO;
use App\Shared\Application\Services\CompactHTMLBodyService;
use App\Shared\Domain\Contracts\EventContract;
use Override;

/**
 * Builder de formato de email para el evento de exportación masiva de registros.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class LaravelTooManyRecordsExportedEmailFormatBuilder implements EmailFormatBuilderContract
{
    public function __construct(
        private CompactHTMLBodyService $compact,
        private UsuarioRepositoryContract $userRepository,
    ) {}

    #[Override]
    public function build(EventContract $event, Usuario $usuario): EmailMessageDTO
    {
        /** @var TooManyRecordsExported $event */
        $exportacion = $event->getExportacion();

        /** @var ?Usuario */
        $user = $this->userRepository->findById($exportacion->getUserId());

        $body = view('exportaciones.too-many-records-exported', [
            'exportId' => $exportacion->getId(),
            'adminName' => $usuario->getName(),
            'userName' => $user?->getName() ?? 'Usuario desconocido',
            'userEmail' => $user?->getEmail() ?? 'N/A',
            'table' => $exportacion->getTable()->value,
            'recordsCount' => $exportacion->getRecordsCount(),
            'format' => $exportacion->getFormat()->value,
            'filename' => $exportacion->getFilename(),
            'exportedAt' => $event->ocurredOn()->getPeriod(),
        ])->render();

        $minifiedBody = $this->compact->compact($body);

        return new EmailMessageDTO(
            to: $usuario->getEmail(),
            subject: 'Alerta de exportación masiva en Leo Counter',
            htmlBody: $minifiedBody,
        );
    }

    #[Override]
    public function supports(EventContract $event): bool
    {
        return $event instanceof TooManyRecordsExported;
    }
}
