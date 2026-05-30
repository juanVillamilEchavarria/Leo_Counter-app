<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Notificacion\Commands;

/**
 * Comando para eliminar una suscripción.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Notificacion\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class DestroySuscriptorCommand
{
    public function __construct(
        public string $id
    ){}
}
