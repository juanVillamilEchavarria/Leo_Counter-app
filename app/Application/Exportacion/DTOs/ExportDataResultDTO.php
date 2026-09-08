<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\DTOs;

use App\Shared\Domain\Contracts\CollectionContract;

/**
 * DTO que representa el resultado estructurado de una exportación.
 * Contiene las cabeceras y las filas listas para ser escritas en un archivo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
final readonly class ExportDataResultDTO
{
    public function __construct(
        /** @var array<string> Cabeceras del archivo ['Fecha', 'Monto', ...] */
        public array $headers,
        /** @var CollectionContract Filas, cada una como array asociativo */
        public CollectionContract $rows
    ) {}
}
