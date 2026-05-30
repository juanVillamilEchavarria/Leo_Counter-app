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
