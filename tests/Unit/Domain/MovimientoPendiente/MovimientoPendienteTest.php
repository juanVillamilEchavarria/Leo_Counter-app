<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\MovimientoPendiente;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoPendiente\Aggregates\MovimientoPendiente;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Domains\MovimientoPendiente\Exceptions\CannotStoreMovimientoPendienteException;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class MovimientoPendienteTest extends TestCase
{
    private MovimientoPendienteId $id;
    private CategoriaId $categoriaId;
    private CuentaId $cuentaId;
    private Date $fecha;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = MovimientoPendienteId::generate($this->idGenerator);
        $this->categoriaId = CategoriaId::generate($this->idGenerator);
        $this->cuentaId = CuentaId::generate($this->idGenerator);
        $this->fecha = new Date(new DateTimeImmutable());
    }

    /**
     * Valida creación exitosa.
     */
    public function test_it_can_create_movimiento_pendiente(): void
    {
        $movimiento = MovimientoPendiente::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz',
            monto: new Amount(30),
            fecha_programada: $this->fecha,
            dias_aviso: 2,
            descripcion: null
        );

        $this->assertEquals('Luz', $movimiento->getNombre());
        $this->assertEquals(EstadosMovimientoPendiente::PENDIENTE, $movimiento->getEstado());
    }

    /**
     * Valida excepción al crear si los días de aviso son negativos.
     */
    public function test_it_throws_exception_if_dias_aviso_negative(): void
    {
        $this->expectException(CannotStoreMovimientoPendienteException::class);

        MovimientoPendiente::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz',
            monto: new Amount(30),
            fecha_programada: $this->fecha,
            dias_aviso: -1
        );
    }

    /**
     * Valida marcar como realizado.
     */
    public function test_it_can_mark_as_done(): void
    {
        $movimiento = MovimientoPendiente::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz',
            monto: new Amount(30),
            fecha_programada: $this->fecha
        );

        $done = $movimiento->markAsDone();

        $this->assertNotSame($movimiento, $done);
        $this->assertEquals(EstadosMovimientoPendiente::REALIZADO, $done->getEstado());
    }

    /**
     * Valida marcar como vencido.
     */
    public function test_it_can_mark_as_expired(): void
    {
        $movimiento = MovimientoPendiente::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz',
            monto: new Amount(30),
            fecha_programada: $this->fecha
        );

        $expired = $movimiento->markAsExpired();

        $this->assertNotSame($movimiento, $expired);
        $this->assertEquals(EstadosMovimientoPendiente::VENCIDO, $expired->getEstado());
    }

    /**
     * Valida la actualización de datos.
     */
    public function test_it_can_update_data(): void
    {
        $movimiento = MovimientoPendiente::reconstitute(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            movimiento_fijo_id: null,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz',
            monto: new Amount(30),
            fecha_programada: $this->fecha,
            dias_aviso: 1,
            descripcion: null,
            estado: EstadosMovimientoPendiente::PENDIENTE
        );

        $updated = $movimiento->updateData(
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            nombre: 'Luz Modificado',
            monto: new Amount(40),
            fecha_programada: $this->fecha,
            dias_aviso: 1,
            descripcion: 'Aumento de tarifa'
        );

        $this->assertNotSame($movimiento, $updated);
        $this->assertEquals('Luz Modificado', $updated->getNombre());
        $this->assertEquals(new Amount(40), $updated->getMonto());
        $this->assertEquals('Aumento de tarifa', $updated->getDescripcion());
    }
}
