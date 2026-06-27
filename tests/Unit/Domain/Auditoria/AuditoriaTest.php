<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace Tests\Unit\Domain\Auditoria;

use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Domains\Auditoria\Enums\AuditableActions;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\ValueObjects\AuditableRegisterId;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\JsonPayload;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class AuditoriaTest extends TestCase
{
    private AuditoriaId $id;
    private UsuarioId $userId;
    private AuditableRegisterId $registerId;
    private IdGeneratorContract $idGenerator;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = AuditoriaId::generate($this->idGenerator);
        $this->userId = UsuarioId::generate($this->idGenerator);
        $this->registerId = AuditableRegisterId::generate($this->idGenerator);
    }

    /**
     * Valida creación de un registro de auditoria.
     */
    public function test_it_can_create_auditoria(): void
    {
        $oldValues = new JsonPayload(['name' => 'old']);
        $newValues = new JsonPayload(['name' => 'new']);

        $auditoria = Auditoria::create(
            id: $this->id,
            user_id: $this->userId,
            auditable_type: AuditableTypes::MOVIMIENTOS,
            auditable_id: $this->registerId,
            action: AuditableActions::UPDATE,
            old_values: $oldValues,
            new_values: $newValues
        );

        $this->assertEquals(AuditableTypes::MOVIMIENTOS, $auditoria->getAuditableType());
        $this->assertEquals(AuditableActions::UPDATE, $auditoria->getAction());
        $this->assertSame($oldValues, $auditoria->getOldValues());
        $this->assertSame($newValues, $auditoria->getNewValues());
    }

    /**
     * Valida reconstitución.
     */
    public function test_it_can_reconstitute_auditoria(): void
    {
        $newValues = new JsonPayload(['name' => 'test']);

        $auditoria = Auditoria::reconstitute(
            id: $this->id,
            user_id: $this->userId,
            auditable_type: AuditableTypes::PRESUPUESTOS,
            auditable_id: $this->registerId,
            action: AuditableActions::CREATE,
            old_values: null,
            new_values: $newValues
        );

        $this->assertEquals(AuditableTypes::PRESUPUESTOS, $auditoria->getAuditableType());
        $this->assertNull($auditoria->getOldValues());
        $this->assertSame($newValues, $auditoria->getNewValues());
    }
}
