<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Notificacion\Aggregates;

use App\Domains\Notificacion\ValueObjects\CanalId;
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
final readonly class Canal implements AggregateModelContract
{
    private function __construct(
        private CanalId $id,
        private string  $nombre,
        private bool    $active = true
    ) {
    }

    /**
     * Reconstituye el agregado desde persistencia.
     */
    public static function reconstitute(
        CanalId $id,
        string  $nombre,
        bool    $activo
    ): self {
        return new self(id: $id, nombre: $nombre, active: $activo);
    }

    /**
     * Alterna el estado activo del canal devolviendo una nueva instancia.
     */
    public function toggleActive(): self
    {
        return new self(id: $this->id, nombre: $this->nombre, active: !$this->active);
    }

    public function getId(): CanalId
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}

