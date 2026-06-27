<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Propietario;

use App\Domains\Propietario\Aggregates\Propietario;
use App\Domains\Propietario\Contracts\PropietarioUniquenessCheckerContract;
use App\Domains\Propietario\Exceptions\PropietarioEmailNotUniqueException;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\ValueObjects\Email;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class PropietarioTest extends TestCase
{
    private PropietarioId $id;
    private PropietarioUniquenessCheckerContract $checker;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = PropietarioId::generate($this->idGenerator);
        $this->checker = $this->createMock(PropietarioUniquenessCheckerContract::class);
    }

    /**
     * Valida creación de un propietario válido.
     */
    public function test_it_can_create_a_valid_propietario(): void
    {
        $this->checker->method('exists')->willReturn(false);
        $email = new Email('test@test.com');

        $propietario = Propietario::create(
            id: $this->id,
            nombre: 'Juan',
            apellido: 'Perez',
            telefono: '123456789',
            email: $email,
            checker: $this->checker
        );

        $this->assertEquals('Juan', $propietario->getNombre());
        $this->assertEquals('Perez', $propietario->getApellido());
        $this->assertEquals('123456789', $propietario->getTelefono());
        $this->assertSame($email, $propietario->getEmail());
    }

    /**
     * Valida excepción por email duplicado al crear.
     */
    public function test_it_throws_exception_if_email_exists_when_creating(): void
    {
        $this->checker->method('exists')->willReturn(true);
        $email = new Email('test@test.com');

        $this->expectException(PropietarioEmailNotUniqueException::class);

        Propietario::create(
            id: $this->id,
            nombre: 'Juan',
            apellido: 'Perez',
            telefono: '123456789',
            email: $email,
            checker: $this->checker
        );
    }

    /**
     * Valida actualizar datos del propietario.
     */
    public function test_it_can_update_data(): void
    {
        $this->checker->method('exists')->willReturn(false);
        $email = new Email('test@test.com');

        $propietario = Propietario::reconstitute(
            id: $this->id,
            nombre: 'Juan',
            apellido: 'Perez',
            telefono: '123456789',
            email: $email
        );

        $newEmail = new Email('nuevo@test.com');
        $updated = $propietario->updateData(
            nombre: 'Juan Editado',
            apellido: 'Perez Editado',
            telefono: '987654321',
            email: $newEmail,
            checker: $this->checker
        );

        $this->assertNotSame($propietario, $updated);
        $this->assertEquals('Juan Editado', $updated->getNombre());
        $this->assertSame($newEmail, $updated->getEmail());
    }
}
