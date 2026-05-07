<?php

namespace App\Domains\Propietario\Aggregates;

use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Exceptions\PropietarioEmailNotUniqueException;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Agregado raíz del dominio Propietario.
 * Representa un propietario del sistema con su información de contacto básica.
 */
final readonly class Propietario implements AggregateModelContract
{
    private function __construct(
        private string $nombre,
        private string $apellido,
        private string $telefono,
        private Email $email,
    ) {
    }

    /**
     * Crea un nuevo propietario.
     * @param string $nombre
     * @param string $apellido
     * @param string $telefono
     * @param Email $email
     * @param PropietarioUniquenessCheckerContract $checker
     * @return self
     */
    public static function create(
        string $nombre,
        string $apellido,
        string $telefono,
        Email $email,
        PropietarioUniquenessCheckerContract $checker,
    ): self {
        if ($checker->exists($email)) {
            throw new PropietarioEmailNotUniqueException();
        }

        return new self(
            nombre: trim($nombre),
            apellido: trim($apellido),
            telefono: trim($telefono),
            email: $email,
        );
    }

    /**
     * Reconstituye el agregado desde la persistencia.
     * @param string $nombre
     * @param string $apellido
     * @param string $telefono
     * @param Email $email
     * @return self
     */
    public static function reconstitute(
        string $nombre,
        string $apellido,
        string $telefono,
        Email $email,
    ): self {
        return new self(
            nombre: $nombre,
            apellido: $apellido,
            telefono: $telefono,
            email: $email,
        );
    }

    /**
     * Actualiza los datos del propietario.
     * @param string $nombre
     * @param string $apellido
     * @param string $telefono
     * @param Email $email
     * @param PropietarioUniquenessCheckerContract $checker
     * @param int|null $excludeId
     * @return self
     */
    public function updateData(
        string $nombre,
        string $apellido,
        string $telefono,
        Email $email,
        PropietarioUniquenessCheckerContract $checker,
        ?int $excludeId = null,
    ): self {
        if ($checker->exists($email, $excludeId)) {
            throw new PropietarioEmailNotUniqueException();
        }

        return new self(
            nombre: trim($nombre),
            apellido: trim($apellido),
            telefono: trim($telefono),
            email: $email,
        );
    }

    
    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
