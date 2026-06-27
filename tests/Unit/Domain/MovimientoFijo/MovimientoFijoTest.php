<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\MovimientoFijo;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\Aggregates\MovimientoFijo;
use App\Domains\MovimientoFijo\Enums\FrecuenciaMovimientoEnum;
use App\Domains\MovimientoFijo\Exceptions\CannotStoreMovimientoFijoException;
use App\Domains\MovimientoFijo\Resolvers\RecalculateNextDateResolver;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class MovimientoFijoTest extends TestCase
{
    private MovimientoFijoId $id;
    private CategoriaId $categoriaId;
    private CuentaId $cuentaId;
    private Date $fechaProximo;
    private RecalculateNextDateResolver $resolver;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = MovimientoFijoId::generate($this->idGenerator);
        $this->categoriaId = CategoriaId::generate($this->idGenerator);
        $this->cuentaId = CuentaId::generate($this->idGenerator);
        $this->fechaProximo = new Date(new DateTimeImmutable());
        $this->resolver = new RecalculateNextDateResolver([]);
    }

    /**
     * Valida creación exitosa.
     */
    public function test_it_can_create_movimiento_fijo(): void
    {
        $movimiento = MovimientoFijo::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::MENSUAL,
            nombre: 'Netflix',
            monto: new Amount(15),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: 2,
            descripcion: null
        );

        $this->assertEquals('Netflix', $movimiento->getNombre());
        $this->assertTrue($movimiento->getActive());
        $this->assertFalse($movimiento->getRegistrarAutomatico());
    }

    /**
     * Valida excepción al crear si los días de aviso son negativos.
     */
    public function test_it_throws_exception_if_dias_aviso_negative(): void
    {
        $this->expectException(CannotStoreMovimientoFijoException::class);

        MovimientoFijo::create(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::MENSUAL,
            nombre: 'Netflix',
            monto: new Amount(15),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: -1,
            descripcion: null
        );
    }

    /**
     * Valida reconstitución.
     */
    public function test_it_can_reconstitute_movimiento_fijo(): void
    {
        $movimiento = MovimientoFijo::reconstitute(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::ANUAL,
            nombre: 'Bono',
            monto: new Amount(100),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: 5,
            descripcion: 'Bono anual',
            active: true,
            registrar_automatico: true
        );

        $this->assertTrue($movimiento->getRegistrarAutomatico());
        $this->assertEquals('Bono', $movimiento->getNombre());
    }

    /**
     * Valida actualización de datos.
     */
    public function test_it_can_update_data(): void
    {
        $movimiento = MovimientoFijo::reconstitute(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::ANUAL,
            nombre: 'Bono',
            monto: new Amount(100),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: 5,
            descripcion: null,
            active: true,
            registrar_automatico: true
        );

        $updated = $movimiento->updateData(
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::INGRESO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::ANUAL,
            nombre: 'Bono Especial',
            monto: new Amount(200),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: 2,
            descripcion: null
        );

        $this->assertNotSame($movimiento, $updated);
        $this->assertEquals('Bono Especial', $updated->getNombre());
        $this->assertEquals(new Amount(200), $updated->getMonto());
    }

    /**
     * Valida el recalculo de la proxima fecha.
     */
    public function test_it_can_recalculate_next_date(): void
    {
        $movimiento = MovimientoFijo::reconstitute(
            id: $this->id,
            categoria_id: $this->categoriaId,
            cuenta_id: $this->cuentaId,
            tipo_movimiento_id: TipoMovimientoEnum::GASTO,
            frecuencia_movimiento_id: FrecuenciaMovimientoEnum::MENSUAL,
            nombre: 'Sub',
            monto: new Amount(10),
            fecha_proximo: $this->fechaProximo,
            dias_aviso: 1,
            descripcion: null,
            active: true,
            registrar_automatico: false
        );

        $strategyMock = $this->createMock(\App\Domains\MovimientoFijo\Contracts\Strategies\RecalculateNextDateStrategyContract::class);
        $strategyMock->method('supports')->willReturn(true);
        $nextDate = new Date((new DateTimeImmutable())->add(new \DateInterval('P1M')));
        $strategyMock->method('recalculateNextDate')->willReturn($nextDate);
        $resolver = new RecalculateNextDateResolver([$strategyMock]);

        $updated = $movimiento->recalculateNextDate($resolver);

        $this->assertNotSame($movimiento, $updated);
        $this->assertEquals($nextDate, $updated->getFechaProximo());
    }
}
