<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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

    /**
     * @param array<EventContract> $events
     * @return void
     */
    public function publishMany(array $events):void;

}
