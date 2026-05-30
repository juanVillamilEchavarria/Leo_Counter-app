<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\ArchivoMovimiento\Builders;

use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;

final readonly class FilePathBuilder {
    public static function buildFromNow(string $tipo_movimiento, string $categoria): FilePath {
        $date = new \DateTimeImmutable();
        return new FilePath(
            $date->format('Y'),
            $date->format('m'),
            $tipo_movimiento,
            $categoria
        );
     }

}
