<?php

namespace App\Domains\Notificacion\Aggregates;

use App\Domains\Notificacion\ValueObjects\CanalNotificacionId;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Agregado raíz para Canales de Notificación.
 * Representa un canal (ej. email) con su configuración y estado activo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Notificacion\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CanalNotificacion implements AggregateModelContract
{
    private function __construct(
        private CanalNotificacionId $id,
        private string $nombre,
        private bool $activo = true,
        private ?array $configuracion = null
    ) {
    }

    /**
     * Reconstituye el agregado desde persistencia.
     */
    public static function reconstitute(
        CanalNotificacionId $id,
        string $nombre,
        bool $activo,
        ?array $configuracion = null
    ): self {
        return new self(id: $id, nombre: $nombre, activo: $activo, configuracion: $configuracion);
    }

    /**
     * Alterna el estado activo del canal devolviendo una nueva instancia.
     */
    public function toggleActive(): self
    {
        return new self(id: $this->id, nombre: $this->nombre, activo: !$this->activo, configuracion: $this->configuracion);
    }

    /**
     * Actualiza la configuración del canal devolviendo una nueva instancia.
     */
    public function actualizarConfiguracion(array $configuracion): self
    {
        return new self(id: $this->id, nombre: $this->nombre, activo: $this->activo, configuracion: $configuracion);
    }

    public function getId(): CanalNotificacionId
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function getConfiguracion(): ?array
    {
        return $this->configuracion;
    }
}
