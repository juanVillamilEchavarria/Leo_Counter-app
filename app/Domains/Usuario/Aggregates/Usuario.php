<?php

namespace App\Domains\Usuario\Aggregates;

use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\Exceptions\WrongPasswordException;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;
use DateTimeInterface;
use InvalidArgumentException;

/**
 * Agregado raíz del dominio Usuario.
 * Representa al usuario autenticable y encapsula las reglas de actualización de perfil.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Usuario\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Usuario implements AggregateModelContract
{
    private const PASSWORD_MIN_LENGTH = 8;

    private function __construct(
        private UsuarioId $id,
        private string    $name,
        private Email     $email,
        private string    $password,
        private Roles     $role,
    ) {
    }

    /**
     * Reconstituye un usuario desde los datos persistidos.
     *
     * @param UsuarioId $id Identificador del usuario.
     * @param string $name Nombre del usuario.
     * @param Email $email Correo electrónico del usuario.
     * @param string $password Hash de contraseña persistido.
     * @param Roles $role Rol del usuario.
     * @return self
     */
    public static function reconstitute(
        UsuarioId $id,
        string    $name,
        Email     $email,
        string    $password,
        Roles     $role,
    ): self {
        return new self(
            id: $id,
            name: $name,
            email: $email,
            password: $password,
            role: $role,
        );
    }

    /**
     * Actualiza los datos públicos del usuario.
     *
     * @param string $name Nombre público.
     * @param Email $email Correo electrónico.
     * @return self
     */
    public function updatePublicData(string $name, Email $email): self
    {
        $name = trim($name);

        if ($name === '') {
            throw new InvalidArgumentException('El nombre del usuario no puede estar vacío.');
        }


        return new self(
            id: $this->id,
            name: $name,
            email: $email,
            password: $this->password,
            role: $this->role,
        );
    }

    /**
     * Cambia la contraseña del usuario verificando primero la contraseña actual.
     *
     * @param string $currentPassword Contraseña actual plana.
     * @param string $newPassword Nueva contraseña plana.
     * @param PasswordHasherContract $hasher Servicio de hash.
     * @return self
     */
    public function changePassword(string $currentPassword, string $newPassword, PasswordHasherContract $hasher): self
    {
        if (!$hasher->check($currentPassword, $this->password)) {
            throw new WrongPasswordException();
        }

        if (strlen($newPassword) < self::PASSWORD_MIN_LENGTH) {
            throw new InvalidArgumentException('La contraseña debe tener al menos 8 caracteres.');
        }

        return new self(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $hasher->make($newPassword),
            role: $this->role,
        );
    }

    public function getId(): UsuarioId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Roles
    {
        return $this->role;
    }

}
