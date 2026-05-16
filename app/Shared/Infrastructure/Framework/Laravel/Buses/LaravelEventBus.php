<?php

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
}
