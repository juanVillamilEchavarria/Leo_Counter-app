<?php

namespace App\Shared\Domain\Contracts;

use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Usuario\Aggregates\Usuario;

/**
 * Contrato de las estrategias para enviar mensajes a los usuarios via canales.
 * Estas estrategis no tienen un metodo supports que verifique si se pueden enviar, ya que esta pensado para enviar masivamente los mensajes por todos los canales disponibles.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Domain\Contracts
 * @since 1.0.0
 * @version 1.0.0
 */
interface SendMessageToUserByChannelStrategyContract
{
    /**
     * Retorna el canal de notificacion
     * @return Canal
     */

    public function getChanel(): Canal;
    /**
     * Verifica si el usuario puede ser notificado via el canal
     * @param Usuario $usuario
     * @return bool
     */
    public function supports(Usuario $usuario) : bool;
    /**
     * Envía el mensaje al usuario
     * @param EventContract $event
     * @param Usuario $usuario
     * @return void
     */
    public function sendMessage(EventContract $event, Usuario $usuario): void;

}
