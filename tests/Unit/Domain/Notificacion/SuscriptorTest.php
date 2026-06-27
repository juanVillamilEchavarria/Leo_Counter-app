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

use App\Domains\Notificacion\Aggregates\Suscriptor;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\Exceptions\CannotStoreSuscriptorNotificacionException;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use PHPUnit\Framework\TestCase;

final class SuscriptorTest extends TestCase
{
    private SuscriptorId $id;
    private UsuarioId $usuarioId;
    private CanalId $canalId;
    private SuscriptorUniquenessCheckerContract $checker;
    private IdGeneratorContract $idGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->idGenerator = $this->createMock(IdGeneratorContract::class);
        $this->idGenerator->method('generate')->willReturn('uuid-falso');

        $this->id = SuscriptorId::generate($this->idGenerator);
        $this->usuarioId = UsuarioId::generate($this->idGenerator);
        $this->canalId = CanalId::generate($this->idGenerator);
        $this->checker = $this->createMock(SuscriptorUniquenessCheckerContract::class);
    }

    /**
     * Valida creación exitosa.
     */
    public function test_it_can_create_suscriptor(): void
    {
        $this->checker->method('exists')->willReturn(false);

        $suscriptor = Suscriptor::create(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            checker: $this->checker
        );

        $this->assertTrue($suscriptor->isActive());
        $this->assertNull($suscriptor->getVerifiedAt());
    }

    /**
     * Valida excepción si ya existe la suscripción.
     */
    public function test_it_throws_exception_if_subscription_exists(): void
    {
        $this->checker->method('exists')->willReturn(true);

        $this->expectException(CannotStoreSuscriptorNotificacionException::class);
        $this->expectExceptionMessage('El usuario ya está suscrito a este canal.');

        Suscriptor::create(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            checker: $this->checker
        );
    }

    /**
     * Valida reconstitución.
     */
    public function test_it_can_reconstitute_suscriptor(): void
    {
        $date = new Date(new DateTimeImmutable());
        $suscriptor = Suscriptor::reconstitute(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            verified_at: $date,
            activo: false
        );

        $this->assertFalse($suscriptor->isActive());
        $this->assertEquals($date, $suscriptor->getVerifiedAt());
    }

    /**
     * Valida actualizar datos.
     */
    public function test_it_can_update_data(): void
    {
        $this->checker->method('exists')->willReturn(false);
        $suscriptor = Suscriptor::reconstitute(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            verified_at: null,
            activo: true
        );

        $newCanalId = CanalId::generate($this->idGenerator);
        
        $updated = $suscriptor->updateData(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $newCanalId,
            checker: $this->checker
        );

        $this->assertNotSame($suscriptor, $updated);
        $this->assertSame($newCanalId, $updated->getCanalNotificacionId());
    }

    /**
     * Valida alternar estado activo.
     */
    public function test_it_can_toggle_active_status(): void
    {
        $suscriptor = Suscriptor::reconstitute(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            verified_at: null,
            activo: true
        );

        $toggled = $suscriptor->toggleActive();

        $this->assertNotSame($suscriptor, $toggled);
        $this->assertFalse($toggled->isActive());
    }

    /**
     * Valida verificar la suscripción.
     */
    public function test_it_can_verify_subscription(): void
    {
        $suscriptor = Suscriptor::reconstitute(
            id: $this->id,
            userId: $this->usuarioId,
            canalNotificacionId: $this->canalId,
            verified_at: null,
            activo: true
        );

        $verified = $suscriptor->verify();

        $this->assertNotSame($suscriptor, $verified);
        $this->assertNotNull($verified->getVerifiedAt());
    }
}
