<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Application\Transferencia\Queries;

use App\Application\Transferencia\Contracts\Queries\ListTransferenciaQueryContract;

/**
 * Query que representa la intención de obtener el conteo de registros de transferencias.
 * Se utiliza cuando solo se necesita conocer el número total de transferencias en el sistema.
 *
 * @package App\Application\Transferencia\Queries
 */
final readonly class GetTransferenciaRecordsCountQuery implements ListTransferenciaQueryContract
{
}
