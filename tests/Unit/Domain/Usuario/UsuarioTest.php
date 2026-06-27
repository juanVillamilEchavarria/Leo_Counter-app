<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Usuario;

use App\Domains\Usuario\Aggregates\Usuario;
use App\Domains\Usuario\Contracts\Checkers\UsuarioCanUpdatePublicDataCheckerContract;
use App\Domains\Usuario\Contracts\Checkers\UsuarioUniquinessCheckerContract;
use App\Domains\Usuario\Contracts\Services\PasswordHasherContract;
use App\Domains\Usuario\Enums\Roles;
use App\Domains\Usuario\Exceptions\CannotCreateTheAdminUserException;
use App\Domains\Usuario\Exceptions\CannotUpdateUserDataRelatedToANotificationChannel;
use App\Domains\Usuario\Exceptions\WrongPasswordException;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\ValueObjects\Password;
use InvalidArgumentException;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class UsuarioTest extends TestCase
{
    private UsuarioId $id;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = UsuarioId::generate($this->idGenerator);
    }

    /**
     * Valida creación de un usuario (miembro).
     */
    public function test_it_can_create_a_member_user(): void
    {
        $email = new Email('user@test.com');
        $password = Password::create('12345678');

        $usuario = Usuario::create(
            id: $this->id,
            name: 'User',
            email: $email,
            password: $password
        );

        $this->assertEquals('User', $usuario->getName());
        $this->assertEquals(Roles::MEMBER, $usuario->getRole());
        $this->assertFalse($usuario->isAdmin());
    }

    /**
     * Valida creación del usuario administrador.
     */
    public function test_it_can_create_admin_user(): void
    {
        $email = new Email('admin@test.com');
        $password = Password::create('admin1234');
        $checker = $this->createMock(UsuarioUniquinessCheckerContract::class);
        $checker->method('checkIfAdminWasAlreadyCreated')->willReturn(false);

        $usuario = Usuario::createAdmin(
            id: $this->id,
            name: 'Admin',
            email: $email,
            password: $password,
            checker: $checker
        );

        $this->assertEquals(Roles::ADMIN, $usuario->getRole());
        $this->assertTrue($usuario->isAdmin());
    }

    /**
     * Valida excepción si ya existe un admin al intentar crear otro.
     */
    public function test_it_throws_exception_if_admin_already_exists(): void
    {
        $email = new Email('admin@test.com');
        $password = Password::create('admin1234');
        $checker = $this->createMock(UsuarioUniquinessCheckerContract::class);
        $checker->method('checkIfAdminWasAlreadyCreated')->willReturn(true);

        $this->expectException(CannotCreateTheAdminUserException::class);
        
        Usuario::createAdmin(
            id: $this->id,
            name: 'Admin2',
            email: $email,
            password: $password,
            checker: $checker
        );
    }

    /**
     * Valida actualizar datos públicos permitidos.
     */
    public function test_it_can_update_public_data(): void
    {
        $usuario = Usuario::reconstitute(
            id: $this->id,
            name: 'User',
            email: new Email('user@test.com'),
            password: Password::fromHash('hashedpass'),
            role: Roles::MEMBER
        );

        $checker = $this->createMock(UsuarioCanUpdatePublicDataCheckerContract::class);
        $checker->method('userCanUpdateHisPublicDataRelatedToANotificationChannel')->willReturn(true);

        $newEmail = new Email('new@test.com');
        $updated = $usuario->updatePublicData('New Name', $newEmail, $checker);

        $this->assertNotSame($usuario, $updated);
        $this->assertEquals('New Name', $updated->getName());
        $this->assertEquals('new@test.com', $updated->getEmail()->__toString());
    }

    /**
     * Valida excepción si intenta actualizar correo sin permisos.
     */
    public function test_it_throws_exception_if_cannot_update_email_due_to_channel(): void
    {
        $usuario = Usuario::reconstitute(
            id: $this->id,
            name: 'User',
            email: new Email('user@test.com'),
            password: Password::fromHash('hashedpass'),
            role: Roles::MEMBER
        );

        $checker = $this->createMock(UsuarioCanUpdatePublicDataCheckerContract::class);
        $checker->method('userCanUpdateHisPublicDataRelatedToANotificationChannel')->willReturn(false);

        $this->expectException(CannotUpdateUserDataRelatedToANotificationChannel::class);

        $usuario->updatePublicData('User', new Email('new@test.com'), $checker);
    }

    /**
     * Valida cambio de contraseña propia con clave actual correcta.
     */
    public function test_it_can_change_own_password(): void
    {
        $usuario = Usuario::reconstitute(
            id: $this->id,
            name: 'User',
            email: new Email('user@test.com'),
            password: Password::fromHash('hashedpass'),
            role: Roles::MEMBER
        );

        $hasher = $this->createMock(PasswordHasherContract::class);
        $hasher->method('check')->willReturn(true);

        $newPassword = Password::create('newpass123');
        $updated = $usuario->changeOwnPassword('oldpass', $newPassword, $hasher);

        $this->assertNotSame($usuario, $updated);
        $this->assertSame($newPassword, $updated->getPassword());
    }

    /**
     * Valida excepción por clave incorrecta.
     */
    public function test_it_throws_exception_on_wrong_password(): void
    {
        $usuario = Usuario::reconstitute(
            id: $this->id,
            name: 'User',
            email: new Email('user@test.com'),
            password: Password::fromHash('hashedpass'),
            role: Roles::MEMBER
        );

        $hasher = $this->createMock(PasswordHasherContract::class);
        $hasher->method('check')->willReturn(false);

        $this->expectException(WrongPasswordException::class);

        $usuario->changeOwnPassword('wrongpass', Password::create('newpass123'), $hasher);
    }

    /**
     * Valida cambio de contraseña administrativo.
     */
    public function test_it_can_change_password_administratively(): void
    {
        $usuario = Usuario::reconstitute(
            id: $this->id,
            name: 'User',
            email: new Email('user@test.com'),
            password: Password::fromHash('hashedpass'),
            role: Roles::MEMBER
        );

        $newPassword = Password::create('newpass123');
        $updated = $usuario->changePassword($newPassword);

        $this->assertNotSame($usuario, $updated);
        $this->assertSame($newPassword, $updated->getPassword());
    }
}
