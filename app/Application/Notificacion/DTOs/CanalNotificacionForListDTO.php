<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\DTOs;

/**
 * Data Transfer Object para Canal de Notificación
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CanalNotificacionForListDTO
{
    public function __construct(
        public string $id,
        public string $nombre,
        public bool $activo
    ){}
}
