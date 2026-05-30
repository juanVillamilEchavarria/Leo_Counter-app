<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Infrastructure\Framework\Laravel\Buses;

use App\Shared\Application\Contracts\Bus\EventBus;
use App\Shared\Domain\Contracts\EventContract;
use Illuminate\Contracts\Events\Dispatcher;

class LaravelEventBus implements EventBus
{
    public function __construct(
        private Dispatcher $eventDispatcher
    )
    {
    }

    public function publish(EventContract $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
    public function publishMany(array $events): void
    {
       foreach ($events as $event){
           $this->eventDispatcher->dispatch($event);
       }
    }
}
