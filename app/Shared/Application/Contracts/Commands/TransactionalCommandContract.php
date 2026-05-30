<?php

namespace App\Shared\Application\Contracts\Commands;

/**
 * Contrato que deben implementar los comandos que necesiten una transaccion a nivel de base de datos, para garantizar la atomicidad de sus efectos en los datos.
 * es necesario que implementen esta interfaz para poder que en el command bus se envuelva denteo de DB::Tansaction
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
interface TransactionalCommandContract
{

}
