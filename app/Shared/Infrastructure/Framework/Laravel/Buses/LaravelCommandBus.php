<?php

namespace App\Shared\Infrastructure\Framework\Laravel\Buses;

use App\Shared\Application\Contracts\Bus\CommandBus;
use Illuminate\Support\Facades\Bus;
use Illuminate\Contracts\Bus\Dispatcher;
class LaravelCommandBus implements CommandBus
{
public function __construct(
    private Dispatcher $dispatcher
)
{
}

    /**
     * @inheritDoc
     */
    public function dispatch($command): mixed
    {
       return $this->dispatcher->dispatch($command);
    }
}
