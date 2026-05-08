<?php

namespace App\Application\Propietario\DTOs;


/**
 * DTO que representa un propietario con sus detalles para mostrar en una lista de varios propietarios.
 * El list with details debe devolver una colección de estos DTO.
 * @see App\Infrastructure\Propietario\Queries\Executors\Eloquent\EloquentListAllPropietariosWithDetailsQueryExecutor
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\DTOs
 * @since 1.0.0
 */
final readonly class PropietarioWithDetailsListDTO{
    public function __construct(
        public string $id,
        public string $nombre,
        public string $apellido,
        public ?string $email,
        public ?string $telefono,
        public int $noCuentas, 
    ) {}
}
