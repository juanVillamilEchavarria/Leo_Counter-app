<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Commands;

use App\Domains\Exportacion\Aggregate\Exportacion;

/**
 * Comando que representa la intención de eliminar un registro de exportación.
 * Recibe el agregado directamente para evitar consultas N+1 innecesarias.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class DestroyExportacionCommand
{
    public function __construct(
        public Exportacion $exportacion
    ) {}
}
