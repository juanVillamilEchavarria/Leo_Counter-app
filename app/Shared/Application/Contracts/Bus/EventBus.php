<?php

namespace App\Shared\Application\Contracts\Bus;
use App\Shared\Domain\Contracts\EventContract;

/**
 * Contrato de bus de eventos, que delega un event handler a un evento en especifico
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Bus
 * @version 1.0.0
 */
interface EventBus
{
    public function publish(EventContract $event): void;

}
