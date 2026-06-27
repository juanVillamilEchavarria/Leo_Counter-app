<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Movimiento;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\Movimiento\Exceptions\CannotUpdateMovimientoException;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class MovimientoTest extends TestCase
{
    private MovimientoId $movimientoId;
    private CuentaId $cuentaId;
    private CategoriaId $categoriaId;
    private Date $fecha;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->movimientoId = MovimientoId::generate($this->idGenerator);
        $this->cuentaId = CuentaId::generate($this->idGenerator);
        $this->categoriaId = CategoriaId::generate($this->idGenerator);
        $this->fecha = new Date(new DateTimeImmutable());
    }

    /**
     * Valida creación de movimiento.
     */
    public function test_it_can_create_movimiento(): void
    {
        $monto = new Amount(100);

        $movimiento = Movimiento::create(
            id: $this->movimientoId,
            nombre: 'Compra Supermercado',
            cuenta_id: $this->cuentaId,
            categoria_id: $this->categoriaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            monto: $monto,
            fecha: $this->fecha,
            descripcion: 'Despensa'
        );

        $this->assertEquals('Compra Supermercado', $movimiento->getNombre());
        $this->assertEquals($monto, $movimiento->getMonto());
    }

    /**
     * Valida excepción si monto es cero.
     */
    public function test_it_throws_exception_when_monto_is_zero(): void
    {
        $this->expectException(CannotExecuteMovimientoTransactionException::class);
        
        Movimiento::create(
            id: $this->movimientoId,
            nombre: 'Prueba',
            cuenta_id: $this->cuentaId,
            categoria_id: $this->categoriaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            monto: new Amount(0),
            fecha: $this->fecha
        );
    }

    /**
     * Valida la eliminación del movimiento genera evento.
     */
    public function test_it_can_delete_movimiento(): void
    {
        $movimiento = Movimiento::reconstitute(
            id: $this->movimientoId,
            nombre: 'Prueba',
            cuenta_id: $this->cuentaId,
            categoria_id: $this->categoriaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            monto: new Amount(100),
            fecha: $this->fecha
        );

        $deleted = $movimiento->delete();

        $this->assertNotSame($movimiento, $deleted);

    }

    /**
     * Valida que se puedan actualizar los datos.
     */
    public function test_it_can_update_data(): void
    {
        $movimiento = Movimiento::reconstitute(
            id: $this->movimientoId,
            nombre: 'Prueba',
            cuenta_id: $this->cuentaId,
            categoria_id: $this->categoriaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            monto: new Amount(100),
            fecha: $this->fecha
        );

        $updated = $movimiento->updateData(
            nombre: 'Actualizado',
            cuenta_id: $this->cuentaId,
            categoria_id: $this->categoriaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            monto: new Amount(200),
            fecha: $this->fecha
        );

        $this->assertNotSame($movimiento, $updated);
        $this->assertEquals('Actualizado', $updated->getNombre());
        $this->assertEquals(new Amount(200), $updated->getMonto());
    }
}
