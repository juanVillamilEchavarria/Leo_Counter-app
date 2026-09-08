<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Infrastructure\Exportacion\Framework\Laravel\EventHandlers;

use App\Application\Exportacion\Events\TooManyRecordsExported;
use App\Application\Usuario\Queries\GetAdminUserQuery;
use App\Shared\Application\Contracts\Bus\QueryBus;
use App\Shared\Application\Strategies\SendEmailMessageToUserStrategy;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

/**
 * Handler que escucha el evento TooManyRecordsExported y notifica al administrador
 * del sistema vía email sobre la exportación masiva realizada.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class LaravelSendMessageToAdminWhenTooManyRecordsExportedEventHandler implements ShouldQueue
{
    public function __construct(
        private QueryBus $queryBus,
        private SendEmailMessageToUserStrategy $sendEmailStrategy,
    ) {}

    public function __invoke(TooManyRecordsExported $event): void
    {
        $admin = $this->queryBus->ask(new GetAdminUserQuery);

        if ($admin === null) {
            Log::warning('[Exportaciones] No se pudo notificar exportación masiva: usuario admin no encontrado.');

            return;
        }

        if (! $this->sendEmailStrategy->supports($admin)) {
            Log::info('[Exportaciones] Admin no tiene canal email activo, se omite notificación.');

            return;
        }

        try {
            $this->sendEmailStrategy->sendMessage($event, $admin);
        } catch (\Throwable $e) {
            Log::error('[Exportaciones] Error al notificar admin de exportación masiva: '.$e->getMessage());
        }
    }
}
