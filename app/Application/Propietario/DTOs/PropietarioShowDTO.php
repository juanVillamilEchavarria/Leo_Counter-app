<?php
namespace App\Application\Propietario\DTOs;
/**
 * DTO que representa un propietario con sus detalles para mostrar.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Propietario\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class PropietarioShowDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public string $apellido,
        public ?string $telefono,
        public ?string $email,
        public array $cuentas,
    ) {}
}
