<?php

namespace App\Application\Propietario\DTOs;

use App\Shared\Abstracts\DTOs\DTO;
/**
 * DTO que representa los datos necesarios para editar un propietario.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final  class PropietarioEditDTO extends DTO{

    public function __construct(
        public int $id,
        public string $nombre,
        public string $apellido,
        public string $telefono,
        public string $email
    )
    {
    }
}