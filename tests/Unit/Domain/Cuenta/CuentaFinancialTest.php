<?php
namespace Tests\Unit\Domain\Cuenta;

use PHPUnit\Framework\TestCase;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Shared\Domain\ValueObjects\Amount;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Propietario\ValueObjects\PropietarioId;
use App\Shared\Domain\Contracts\IdGeneratorContract;

final class CuentaFinancialTest extends TestCase
{
    private IdGeneratorContract $id_generator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->id_generator = $this->createMock(IdGeneratorContract::class);
        $this->id_generator->method('generate')->willReturn('uuid-falso-123');
    }

    public function test_it_updates_saldo_actual_correctly(): void
    {
        // 1. Arrange (Preparar)
        $cuenta = Cuenta::create(
            id: CuentaId::generate($this->id_generator),
            nombre: "Cuenta Principal",
            notas: null,
            saldo_inicial: new Amount(100),
            propietario_id: PropietarioId::generate($this->id_generator),
            tipo_cuenta_id: 1
        );

        $nuevoSaldo = $cuenta->getSaldoActual()->subtract(new Amount(80));
        $cuentaActualizada = $cuenta->updateSaldoActual($nuevoSaldo);

        // verificamos que el monto si haya cambiado
        $this->assertEquals(20, $cuentaActualizada->getSaldoActual()->getValue());
        // la cuenta sin actualizar debe permanecer igual
        $this->assertEquals(100, $cuenta->getSaldoActual()->getValue());
        $this->assertNotSame($cuenta, $cuentaActualizada);
    }
}