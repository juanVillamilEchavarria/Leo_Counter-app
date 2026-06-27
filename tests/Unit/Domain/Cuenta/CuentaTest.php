<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Cuenta;

use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Cuenta\Contracts\CuentaCanUpdateSaldoInicialCheckerContract;
use App\Domains\Cuenta\Exceptions\CannotStoreCuentaException;
use App\Domains\Cuenta\Exceptions\CannotUpdateCuentaException;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class CuentaTest extends TestCase
{
    private CuentaId $cuentaId;
    private PropietarioId $propietarioId;
    private CuentaCanUpdateSaldoInicialCheckerContract $checker;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->cuentaId = CuentaId::generate($this->idGenerator);
        $this->propietarioId = PropietarioId::generate($this->idGenerator);
        $this->checker = $this->createMock(CuentaCanUpdateSaldoInicialCheckerContract::class);
    }

    /**
     * Valida que se pueda crear una cuenta.
     */
    public function test_it_can_create_a_valid_cuenta(): void
    {
        $saldo = new Amount(100);

        $cuenta = Cuenta::create(
            id: $this->cuentaId,
            nombre: 'Cuenta de Ahorros',
            notas: 'Mi cuenta principal',
            saldo_inicial: $saldo,
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 1
        );

        $this->assertEquals('Cuenta de Ahorros', $cuenta->getNombre());
        $this->assertEquals($saldo, $cuenta->getSaldoInicial());
        $this->assertEquals($saldo, $cuenta->getSaldoActual());
        $this->assertTrue($cuenta->getActive());
    }

    /**
     * Valida excepción si el nombre está vacío al crear.
     */
    public function test_it_throws_exception_when_creating_cuenta_with_empty_name(): void
    {
        $this->expectException(CannotStoreCuentaException::class);
        $this->expectExceptionMessage('El nombre de la cuenta es obligatorio.');

        Cuenta::create(
            id: $this->cuentaId,
            nombre: '   ',
            notas: null,
            saldo_inicial: new Amount(100),
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 1
        );
    }

    /**
     * Valida la reconstitución de una cuenta.
     */
    public function test_it_can_reconstitute_cuenta(): void
    {
        $saldoInicial = new Amount(100);
        $saldoActual = new Amount(50);

        $cuenta = Cuenta::reconstitute(
            id: $this->cuentaId,
            nombre: 'Corriente',
            notas: null,
            saldo_inicial: $saldoInicial,
            saldo_actual: $saldoActual,
            active: false,
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 2
        );

        $this->assertEquals('Corriente', $cuenta->getNombre());
        $this->assertFalse($cuenta->getActive());
        $this->assertEquals($saldoActual, $cuenta->getSaldoActual());
    }

    /**
     * Valida actualizar datos correctamente permitiendo cambio de saldo inicial.
     */
    public function test_it_can_update_data_and_sync_saldos(): void
    {
        $this->checker->method('canUpdateSaldoInicial')->willReturn(true);
        $cuenta = Cuenta::reconstitute(
            id: $this->cuentaId,
            nombre: 'Corriente',
            notas: null,
            saldo_inicial: new Amount(100),
            saldo_actual: new Amount(50),
            active: true,
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 2
        );

        $newSaldoInicial = new Amount(200);

        $updated = $cuenta->updateData(
            nombre: 'Corriente Editada',
            notas: 'notas',
            saldo_inicial: $newSaldoInicial,
            saldo_actual: new Amount(50),
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 2,
            id: $this->cuentaId,
            checker: $this->checker
        );

        $this->assertNotSame($cuenta, $updated);
        $this->assertEquals('Corriente Editada', $updated->getNombre());
        $this->assertEquals($newSaldoInicial, $updated->getSaldoInicial());
        $this->assertEquals($newSaldoInicial, $updated->getSaldoActual());
    }

    /**
     * Valida actualizar saldo actual.
     */
    public function test_it_can_update_saldo_actual(): void
    {
        $cuenta = Cuenta::reconstitute(
            id: $this->cuentaId,
            nombre: 'Corriente',
            notas: null,
            saldo_inicial: new Amount(100),
            saldo_actual: new Amount(100),
            active: true,
            propietario_id: $this->propietarioId,
            tipo_cuenta_id: 2
        );

        $newSaldoActual = new Amount(150);
        $updated = $cuenta->updateSaldoActual($newSaldoActual);

        $this->assertNotSame($cuenta, $updated);
        $this->assertEquals($newSaldoActual, $updated->getSaldoActual());
        $this->assertEquals(new Amount(100), $updated->getSaldoInicial());
    }
}
