<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Transferencia;

use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Transferencia\Aggregates\Transferencia;
use App\Domains\Transferencia\Exception\CannotCreateTransferenciaException;
use App\Domains\Transferencia\ValueObjects\TransferenciaId;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class TransferenciaTest extends TestCase
{
    private TransferenciaId $id;
    private CuentaId $cuentaOrigenId;
    private CuentaId $cuentaDestinoId;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = TransferenciaId::generate($this->idGenerator);
        $this->cuentaOrigenId = CuentaId::generate($this->idGenerator);
        $this->cuentaDestinoId = CuentaId::generate($this->idGenerator);
    }

    /**
     * Valida creación exitosa.
     */
    public function test_it_can_create_transferencia(): void
    {
        $fecha = new Date(new DateTimeImmutable());
        $monto = new Amount(50);

        $transferencia = Transferencia::create(
            id: $this->id,
            cuenta_origen_id: $this->cuentaOrigenId,
            cuenta_destino_id: $this->cuentaDestinoId,
            monto: $monto,
            fecha: $fecha,
            descripcion: 'Traspaso de fondos'
        );

        $this->assertEquals('Traspaso de fondos', $transferencia->getDescripcion());
        $this->assertEquals($monto, $transferencia->getMonto());

    }

    /**
     * Valida excepción si la fecha es futura.
     */
    public function test_it_throws_exception_if_date_is_future(): void
    {
        $fechaFutura = new Date((new DateTimeImmutable())->add(new \DateInterval('P1D')));
        $monto = new Amount(50);

        $this->expectException(CannotCreateTransferenciaException::class);
        $this->expectExceptionMessage('La fecha no puede ser futura.');

        Transferencia::create(
            id: $this->id,
            cuenta_origen_id: $this->cuentaOrigenId,
            cuenta_destino_id: $this->cuentaDestinoId,
            monto: $monto,
            fecha: $fechaFutura,
            descripcion: null
        );
    }

    /**
     * Valida excepción si el monto es menor o igual a cero.
     */
    public function test_it_throws_exception_if_monto_is_zero(): void
    {
        $fecha = new Date(new DateTimeImmutable());

        $this->expectException(CannotCreateTransferenciaException::class);
        $this->expectExceptionMessage('El monto debe ser mayor a cero.');

        Transferencia::create(
            id: $this->id,
            cuenta_origen_id: $this->cuentaOrigenId,
            cuenta_destino_id: $this->cuentaDestinoId,
            monto: new Amount(0),
            fecha: $fecha,
            descripcion: null
        );
    }

    /**
     * Valida reconstitución.
     */
    public function test_it_can_reconstitute_transferencia(): void
    {
        $fecha = new Date(new DateTimeImmutable());
        $monto = new Amount(100);

        $transferencia = Transferencia::reconstitute(
            id: $this->id,
            cuenta_origen_id: $this->cuentaOrigenId,
            cuenta_destino_id: $this->cuentaDestinoId,
            monto: $monto,
            fecha: $fecha,
            descripcion: null
        );

        $this->assertEquals($monto, $transferencia->getMonto());
        $this->assertNull($transferencia->getDescripcion());
    }
}
