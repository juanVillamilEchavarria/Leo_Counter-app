<?php

namespace App\Application\Propietario\Commands\Abstracts;

/**
 * Comando base para operaciones de escritura de Propietario.
 * Contiene los campos comunes entre creación y actualización.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands\Abstracts
 * @since 1.0.0
 * @version 1.0.0
 */
abstract readonly class WritePropietarioCommand
{

    public function __construct(
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $email,
    ) {}
}
