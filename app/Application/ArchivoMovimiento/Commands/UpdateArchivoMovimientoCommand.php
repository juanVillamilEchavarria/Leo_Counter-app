<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\ArchivoMovimiento\Commands;

use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Movimiento\ValueObjects\MovimientoId;

/**
 * Command para actualizar un archivo de movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateArchivoMovimientoCommand
{
    public function __construct(
        public ArchivoMovimientoId $id,
        public FilePath $filePath

    ){}

}
