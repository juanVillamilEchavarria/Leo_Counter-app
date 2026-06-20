<?php

/*

@package Leo Counter

@author Juan Villamil juanestebanvillamilechavarria@gmail.com

@license MIT

@copyright 2026 Juan Esteban Villamil Echavarria

@since 1.0.1

@version 1.0.1

*/

namespace App\Application\Auditoria\Queries;

use App\Application\Auditoria\Contracts\Queries\ListAuditoriaQueryContract;

/**
 * Query que representa la intención de obtener el conteo de registros de auditorías.
 * Se utiliza cuando solo se necesita conocer el número total de auditorías en el sistema.
 *
 * @package App\Application\Auditoria\Queries
 */
final readonly class GetAuditoriaRecordsCountQuery implements ListAuditoriaQueryContract
{
}
