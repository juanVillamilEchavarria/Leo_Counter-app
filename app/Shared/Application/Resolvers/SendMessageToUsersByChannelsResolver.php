<?php

namespace App\Shared\Application\Resolvers;
use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\Contracts\SendMessageToUserByChannelStrategyContract;
use App\Shared\Application\Contracts\Queries\Executors\GetUsersWhoCanBeNotifiedQueryExecutorContract;
/**
 * Resuelve la estrategia de envio de mensaje a los usuarios por los canales disponibles
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SendMessageToUsersByChannelsResolver
{
    /**
     * @param iterable<SendMessageToUserByChannelStrategyContract> $strategies
     */
    public function __construct(
        private iterable $strategies,
        private GetUsersWhoCanBeNotifiedQueryExecutorContract $getUsersWhoCanBeNotifiedQueryExecutor
    )
    {
    }
    public function resolve(EventContract $event): void{
        $usuarios = $this->getUsersWhoCanBeNotifiedQueryExecutor->execute();

            foreach($this->strategies as $strategy){
                if(!$strategy->getChanel()->isActive())continue;
                foreach($usuarios as $usuario) {
                    if ($strategy->supports($usuario)) {
                        $strategy->sendMessage($event, $usuario);
                    }
                }
            }

    }

}
