<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Application\Transferencia\Commands;

use App\Shared\Application\Contracts\Commands\CommandContract;

/**
 * Comando para almacenar una nueva transferencia.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.1
 * @version 1.0.1
 */
final readonly class StoreTransferenciaCommand implements CommandContract
{
    public function __construct(
        public string $cuenta_enviadora_id,
        public string $cuenta_receptora_id,
        public float $monto,
        public ?string $descripcion = null
    ) {
    }
}
