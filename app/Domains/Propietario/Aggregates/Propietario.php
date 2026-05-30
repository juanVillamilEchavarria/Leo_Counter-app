<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Propietario\Aggregates;

use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Exceptions\PropietarioEmailNotUniqueException;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;

/**
 * Agregado raíz del dominio Propietario.
 * Representa un propietario del sistema con su información de contacto básica.
 */
final readonly class Propietario implements AggregateModelContract
{
    private function __construct(
        private PropietarioId $id,
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
        PropietarioId $id,
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
            id: $id,
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
        PropietarioId $id,
        string $nombre,
        string $apellido,
        string $telefono,
        Email $email,
    ): self {
        return new self(
            id: $id,
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
     * @return self
     */
    public function updateData(
        string $nombre,
        string $apellido,
        string $telefono,
        Email $email,
        PropietarioUniquenessCheckerContract $checker,
    ): self {
        if ($checker->exists($email, $this->id)) {
            throw new PropietarioEmailNotUniqueException();
        }

        return new self(
            id: $this->id,
            nombre: trim($nombre),
            apellido: trim($apellido),
            telefono: trim($telefono),
            email: $email,
        );
    }

    public function getId(): PropietarioId
    {
        return $this->id;
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
