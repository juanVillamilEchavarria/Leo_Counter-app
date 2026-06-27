<?php
namespace Tests\Unit\Domain\Presupuesto;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Presupuesto\Aggregates\Presupuesto;
use PHPUnit\Framework\TestCase;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

final class PresupuestoTest extends TestCase
{
    private IdGeneratorContract $id_generator;
    private PresupuestoCanDuplicateCheckerContract $checker;
    private PresupuestoUniquenessCheckerContract $uniqueness_checker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->id_generator = $this->createMock(IdGeneratorContract::class);
        $this->checker = $this->createMock(PresupuestoCanDuplicateCheckerContract::class);
        $this->uniqueness_checker = $this->createMock(PresupuestoUniquenessCheckerContract::class);
        $this->id_generator->method('generate')->willReturn('uuid-falso-123');
    }

    public function tests_correctly_duplicate_for_next_month(){
        $date = new Date(new DateTimeImmutable());
        $this->uniqueness_checker->method('isUnique')->willReturn(true);
        $this->checker->method('canDuplicate')->willReturn(true);
        $presupuesto = Presupuesto::create(
            id: PresupuestoId::generate($this->id_generator),
            categoria_id: CategoriaId::generate($this->id_generator),
            monto: new Amount(200),
            periodo: $date,
            descripcion: null,
            user_id: UsuarioId::generate($this->id_generator),
            checker: $this->uniqueness_checker
        );

        $presupuestoDuplicatedForNextMonth = $presupuesto->duplicate($presupuesto->getId(), $this->checker);

        $this->assertNotSame($presupuesto, $presupuestoDuplicatedForNextMonth);
        $this->assertEquals($date->addMonths('1'), $presupuestoDuplicatedForNextMonth->getPeriodo());
    }
    public function tests_it_throws_exception_when_budget_cannot_be_duplicated()
{
    $this->checker->method('canDuplicate')->willReturn(false);

    $presupuesto = Presupuesto::reconstitute(
        id: PresupuestoId::generate($this->id_generator),
        categoria_id: CategoriaId::generate($this->id_generator),
        monto: new Amount(200),
        periodo: new Date(new DateTimeImmutable()),
        descripcion: null,
        user_id: UsuarioId::generate($this->id_generator)
    );

    $this->expectException(\App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException::class);
    $this->expectExceptionMessage('Ya existe un presupuesto duplicado para este');

    $presupuesto->duplicate($presupuesto->getId(), $this->checker);
}


}