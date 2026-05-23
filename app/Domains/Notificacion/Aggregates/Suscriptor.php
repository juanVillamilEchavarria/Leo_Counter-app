<?php

namespace App\Domains\Notificacion\Aggregates;

use App\Domains\Notificacion\ValueObjects\SuscriptorId;
use App\Domains\Notificacion\ValueObjects\CanalId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\Exceptions\CannotStoreSuscriptorNotificacionException;
use App\Domains\Notificacion\Exceptions\CannotUpdateSuscriptorNotificacionException;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Date;
use DateTimeImmutable;

/**
 * Agregado raíz para suscriptores de notificación.
 * Representa la suscripción de un usuario a un canal de notificaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Suscriptor implements AggregateModelContract
{
    private function __construct(
        private SuscriptorId $id,
        private CanalId      $canalNotificacionId,
        private UsuarioId    $userId,
        private ?Date        $verified_at = null,
        private bool $active = true
    ) {
    }

    /**
     * Crea una nueva suscripción verificando unicidad.
     * El campo verified_at se inicializa en null (pendiente de verificación).
     */
    public static function create(
        SuscriptorId                        $id,
        UsuarioId                           $userId,
        CanalId                             $canalNotificacionId,
        SuscriptorUniquenessCheckerContract $checker
    ): self {
        if ($checker->exists($userId->getValue(), $canalNotificacionId->getValue())) {
            throw new CannotStoreSuscriptorNotificacionException(message: 'El usuario ya está suscrito a este canal.');
        }

        return new self(
            id: $id,
            canalNotificacionId: $canalNotificacionId,
            userId: $userId,
            verified_at: null,
            active: true
        );
    }
    public function updateData(
        SuscriptorId                        $id,
        UsuarioId                           $userId,
        CanalId                             $canalNotificacionId,
        SuscriptorUniquenessCheckerContract $checker
    ): self{
        if ($checker->exists($userId->getValue(), $canalNotificacionId->getValue())) {
            throw new CannotStoreSuscriptorNotificacionException(message: 'El usuario ya está suscrito a este canal.');
        }
        return new self(
            id: $id,
            canalNotificacionId: $canalNotificacionId,
            userId: $userId,
            verified_at: $this->verified_at,
            active: $this->active
        );
    }

    /**
     * Reconstituye el agregado desde persistencia.
     */
    public static function reconstitute(
        SuscriptorId $id,
        UsuarioId    $userId,
        CanalId      $canalNotificacionId,
        ?Date        $verified_at,
        bool         $activo
    ): self {
        return new self(
            id: $id,
            canalNotificacionId: $canalNotificacionId,
            userId: $userId,
            verified_at: $verified_at,
            active: $activo
        );
    }

    /**
     * Alterna el estado activo devolviendo una nueva instancia.
     */
    public function toggleActive(): self
    {
        return new self(
            id: $this->id,
            canalNotificacionId: $this->canalNotificacionId,
            userId: $this->userId,
            verified_at: $this->verified_at,
            active: !$this->active
        );
    }

    /**
     * Verifica la suscripción, estableciendo la fecha de verificación al momento actual.
     * Devuelve una nueva instancia inmutable con verified_at = now.
     */
    public function verify(): self
    {
        return new self(
            id: $this->id,
            canalNotificacionId: $this->canalNotificacionId,
            userId: $this->userId,
            verified_at: new Date(new DateTimeImmutable()),
            active: $this->active
        );
    }

    // Getters

    public function getId(): SuscriptorId
    {
        return $this->id;
    }

    public function getCanalNotificacionId(): CanalId
    {
        return $this->canalNotificacionId;
    }

    public function getUserId(): UsuarioId
    {
        return $this->userId;
    }

    public function getVerifiedAt(): ?Date
    {
        return $this->verified_at;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
