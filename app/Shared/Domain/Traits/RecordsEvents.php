<?php

namespace App\Shared\Domain\Traits;


use App\Shared\Domain\Contracts\EventContract;

/**
 * Trato para los agregados de dominio que utilizan eventos
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 *
 */
trait RecordsEvents
{
    /** @var array<int, EventContract> */
    private array $recordedEvents = [];

    protected function recordThat(EventContract $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /** @return array<int, EventContract> */
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}
