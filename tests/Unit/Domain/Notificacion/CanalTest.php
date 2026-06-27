<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Notificacion;

use App\Domains\Notificacion\Aggregates\Canal;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class CanalTest extends TestCase
{
    private CanalId $id;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = CanalId::generate($this->idGenerator);
    }

    /**
     * Valida reconstitución del canal.
     */
    public function test_it_can_reconstitute_canal(): void
    {
        $canal = Canal::reconstitute(
            id: $this->id,
            nombre: 'Email',
            activo: true
        );

        $this->assertEquals('Email', $canal->getNombre());
        $this->assertTrue($canal->isActive());
    }

    /**
     * Valida alternar estado activo.
     */
    public function test_it_can_toggle_active_status(): void
    {
        $canal = Canal::reconstitute(
            id: $this->id,
            nombre: 'Email',
            activo: true
        );

        $toggled = $canal->toggleActive();

        $this->assertNotSame($canal, $toggled);
        $this->assertFalse($toggled->isActive());
    }
}
