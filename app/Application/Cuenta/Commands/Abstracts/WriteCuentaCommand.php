<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\Commands\Abstracts;

/**
 * Abstract command for write operations on Cuenta
 */
abstract readonly class WriteCuentaCommand
{
    public function __construct(
        public string $nombre,
        public ?string $notas,
        public float $saldo_inicial,
        public string $propietario_id,
        public int $tipo_cuenta_id,
    ) {}
}
