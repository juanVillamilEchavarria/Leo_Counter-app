<?php

namespace App\Application\Propietario\Commands;

use App\Application\Propietario\Commands\Abstracts\WritePropietarioCommand;

/**
 * Comando para actualizar un propietario existente.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdatePropietarioCommand extends WritePropietarioCommand
{
    public function __construct(
        public int $id,
        string $nombre,
        string $apellido,
        string $telefono,
        string $email,
    ) {
        parent::__construct($nombre, $apellido, $telefono, $email);
    }
}
