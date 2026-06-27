<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Categoria;

use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Domains\Categoria\Exceptions\CannotStoreCategoriaException;
use App\Domains\Categoria\Exceptions\CannotUpdateCategoriaException;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class CategoriaTest extends TestCase
{
    private CategoriaUniquenessCheckerContract $checker;
    private CategoriaId $categoriaId;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->checker = $this->createMock(CategoriaUniquenessCheckerContract::class);
        $this->categoriaId = CategoriaId::generate($this->idGenerator);
    }

    /**
     * Valida que se puede crear una categoría válida exitosamente.
     */
    public function test_it_can_create_a_valid_category(): void
    {
        $this->checker->method('exists')->willReturn(false);

        $categoria = Categoria::create(
            id: $this->categoriaId,
            nombre: 'Comida',
            tipo_movimiento_id: 1,
            descripcion: 'Gastos de comida',
            checker: $this->checker
        );

        $this->assertEquals('Comida', $categoria->getNombre());
        $this->assertEquals(1, $categoria->getTipoMovimientoId());
        $this->assertEquals('Gastos de comida', $categoria->getDescripcion());
        $this->assertSame($this->categoriaId, $categoria->getId());
    }

    /**
     * Valida que lance excepción si la categoría ya existe.
     */
    public function test_it_throws_exception_when_creating_existing_category(): void
    {
        $this->checker->method('exists')->willReturn(true);

        $this->expectException(CannotStoreCategoriaException::class);
        $this->expectExceptionMessage('La categoría con nombre Comida y tipo de movimiento 1 ya existe.');

        Categoria::create(
            id: $this->categoriaId,
            nombre: 'Comida',
            tipo_movimiento_id: 1,
            descripcion: null,
            checker: $this->checker
        );
    }

    /**
     * Valida la reconstitución de una categoría.
     */
    public function test_it_can_reconstitute_category(): void
    {
        $categoria = Categoria::reconstitute(
            id: $this->categoriaId,
            nombre: 'Transporte',
            tipo_movimiento_id: 2,
            descripcion: null
        );

        $this->assertEquals('Transporte', $categoria->getNombre());
        $this->assertEquals(2, $categoria->getTipoMovimientoId());
        $this->assertNull($categoria->getDescripcion());
    }

    /**
     * Valida la actualización de datos de la categoría.
     */
    public function test_it_can_update_category_data(): void
    {
        $this->checker->method('exists')->willReturn(false);

        $categoria = Categoria::reconstitute(
            id: $this->categoriaId,
            nombre: 'Transporte',
            tipo_movimiento_id: 2,
            descripcion: null
        );

        $updatedCategoria = $categoria->updateData(
            nombre: 'Transporte Público',
            tipo_movimiento_id: 2,
            descripcion: 'Buses y metro',
            checker: $this->checker
        );

        $this->assertNotSame($categoria, $updatedCategoria);
        $this->assertEquals('Transporte Público', $updatedCategoria->getNombre());
        $this->assertEquals('Buses y metro', $updatedCategoria->getDescripcion());
    }

    /**
     * Valida que lance excepción si al actualizar hay colisión de datos.
     */
    public function test_it_throws_exception_when_updating_to_existing_category(): void
    {
        $this->checker->method('exists')->willReturn(true);

        $categoria = Categoria::reconstitute(
            id: $this->categoriaId,
            nombre: 'Transporte',
            tipo_movimiento_id: 2,
            descripcion: null
        );

        $this->expectException(CannotUpdateCategoriaException::class);
        $this->expectExceptionMessage('La categoría con nombre Transporte Público y tipo de movimiento 2 ya existe.');

        $categoria->updateData(
            nombre: 'Transporte Público',
            tipo_movimiento_id: 2,
            descripcion: 'Buses y metro',
            checker: $this->checker
        );
    }
}
