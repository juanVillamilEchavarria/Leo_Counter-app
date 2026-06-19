<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Commands\Handlers;
use App\Application\MovimientoPendiente\Commands\MarkMovimientoPendienteAsExpiredCommand;
use App\Domains\MovimientoPendiente\Contracts\Repositories\MovimientoPendienteRepositoryContract;

/**
 * Manejador para marcar un movimiento pendiente como vencido.
 * realmente lo que hace es eliminar el movimiento pendiente, hace hard delete, este handler es usado por la automatizacion diaria.
 * como viene de la automatizacion, la automatizacion itera sobre todos los registros de la tabla, y envia a este handler unicamente los que vencieron ayer, asi que no hay que validar que el movimiento pendiente vencio ayer.
 * @package App\Application\MovimientoPendiente\Commands\Handlers
 * @since 1.0.0
 * @version 1.0.0
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @see \App\Console\Commands\ProcessDailyFinancialTasks
 */
final readonly class MarkMovimientoPendienteAsExpiredHandler
{
    public function __construct(
        private  MovimientoPendienteRepositoryContract $movimientoPendienteRepositoryContract
    )
    {
    }
    public function __invoke(MarkMovimientoPendienteAsExpiredCommand $command): void
    {
       $movimientoPendiente = $command->movimientoPendiente;
       $this->movimientoPendienteRepositoryContract->hardDelete($movimientoPendiente->getId());
    }

}
