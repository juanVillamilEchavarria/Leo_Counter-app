<?php

namespace App\Application\Configuracion\Commands;
use App\Application\Configuracion\Commands\Abstracts\WriteSoftDeleteRecordCommand;

/**
 * Commando para eliminar un registro de forma definitiva
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Configuracion\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class HardDeleteRecordCommand extends WriteSoftDeleteRecordCommand
{

}
