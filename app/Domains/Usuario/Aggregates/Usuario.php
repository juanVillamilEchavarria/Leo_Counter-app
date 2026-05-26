<?php

namespace App\Domains\Usuario\Aggregates;

use App\Domains\Usuario\Contracts\Checkers\UsuarioCanUpdatePublicDataCheckerContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\Exceptions\CannotUpdateUserDataRelatedToANotificationChannel;
use App\Domains\Usuario\Exceptions\WrongPasswordException;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\ValueObjects\Password;
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
        private Password  $password,
        private Roles     $role,
    ) {
    }

    /**
     * Reconstituye un usuario desde los datos persistidos.
     *
     * @param UsuarioId $id Identificador del usuario.
     * @param string $name Nombre del usuario.
     * @param Email $email Correo electrónico del usuario.
     * @param Password $password Hash de contraseña persistido.
     * @param Roles $role Rol del usuario.
     * @return self
     */
    public static function reconstitute(
        UsuarioId $id,
        string    $name,
        Email     $email,
        Password  $password,
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
     * Crea un nuevo usuario member desde los datos del caso de uso administrativo.
     *
     * @param UsuarioId $id Identificador del usuario.
     * @param string $name Nombre del usuario.
     * @param Email $email Correo electrónico del usuario.
     * @param Password $password Contraseña hasheada mediante Value Object.
     * @return self
     */
    public static function create(
        UsuarioId $id,
        string $name,
        Email $email,
        Password $password,
    ): self {
        return new self(
            id: $id,
            name: trim($name),
            email: $email,
            password: $password,
            role: Roles::MEMBER,
        );
    }

    /**
     * Actualiza los datos públicos del usuario.
     *
     * @param string $name Nombre público.
     * @param Email $email Correo electrónico.
     * @return self
     */
    public function updatePublicData(
        string $name,
        Email $email,
        UsuarioCanUpdatePublicDataCheckerContract $checker
    ): self
    {
        $name = trim($name);
        if ($name === '') {
            throw new InvalidArgumentException('El nombre del usuario no puede estar vacío.');
        }
        if($this->email->__toString() !== $email->__toString()){
            if(!$checker->userCanUpdateHisPublicDataRelatedToANotificationChannel($this->id)){
                throw new CannotUpdateUserDataRelatedToANotificationChannel();
            }
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
     * @param Password $newPassword Nueva contraseña plana.
     * @param PasswordHasherContract $hasher Servicio de hash.
     * @return self
     */
    public function changeOwnPassword(string $currentPassword, Password $newPassword, PasswordHasherContract $hasher): self
    {
        if (!$hasher->check($currentPassword, $this->password->__toString())) {
            throw new WrongPasswordException();
        }


        return new self(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $newPassword,
            role: $this->role,
        );
    }

    /**
     * Cambia la contraseña de un usuario por acción administrativa.
     *
     * @param Password $newPassword Nueva contraseña ya normalizada por el Value Object.
     * @param PasswordHasherContract|null $hasher Servicio opcional para mantener compatibilidad de caso de uso.
     * @return self
     */
    public function changePassword(Password $newPassword, ?PasswordHasherContract $hasher = null): self
    {
        return new self(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            password: $newPassword,
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

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getRole(): Roles
    {
        return $this->role;
    }

}
