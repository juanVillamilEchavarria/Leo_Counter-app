<?php

namespace App\Domains\Notificacion\Aggregates;

use App\Domains\Notificacion\ValueObjects\SuscriptorNotificacionId;
use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Notificacion\Contracts\SuscriptorUniquenessCheckerContract;
use App\Domains\Notificacion\Exceptions\CannotStoreSuscriptorNotificacionException;
use App\Domains\Notificacion\Exceptions\CannotUpdateSuscriptorNotificacionException;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Agregado raíz para suscriptores de notificación.
 * Representa la suscripción de un usuario a un canal de notificaciones.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SuscriptorNotificacion implements AggregateModelContract
{
    private function __construct(
        private SuscriptorNotificacionId $id,
        private CanalNotificacionId $canalNotificacionId,
        private UsuarioId $userId,
        private bool $activo = true
    ) {
    }

    /**
     * Crea una nueva suscripción verificando unicidad.
     */
    public static function create(
        SuscriptorNotificacionId $id,
        UsuarioId $userId,
        CanalNotificacionId $canalNotificacionId,
        SuscriptorUniquenessCheckerContract $checker
    ): self {
        if ($checker->exists($userId->getValue(), $canalNotificacionId->getValue())) {
            throw new CannotStoreSuscriptorNotificacionException(message: 'El usuario ya está suscrito a este canal.');
        }

        return new self(id: $id, canalNotificacionId: $canalNotificacionId, userId: $userId, activo: true);
    }

    /**
     * Reconstituye el agregado desde persistencia.
     */
    public static function reconstitute(
        SuscriptorNotificacionId $id,
        UsuarioId $userId,
        CanalNotificacionId $canalNotificacionId,
        bool $activo
    ): self {
        return new self(id: $id, canalNotificacionId: $canalNotificacionId, userId: $userId, activo: $activo);
    }

    /**
     * Alterna el estado activo devolviendo una nueva instancia.
     */
    public function toggleActive(): self
    {
        return new self(id: $this->id, canalNotificacionId: $this->canalNotificacionId, userId: $this->userId, activo: !$this->activo);
    }

    public function getId(): SuscriptorNotificacionId
    {
        return $this->id;
    }

    public function getCanalNotificacionId(): CanalNotificacionId
    {
        return $this->canalNotificacionId;
    }

    public function getUserId(): UsuarioId
    {
        return $this->userId;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }
}
