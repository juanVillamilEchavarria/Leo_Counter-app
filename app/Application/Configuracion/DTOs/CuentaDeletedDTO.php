<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\DTOs;

/**
 * DTO para representar una cuenta eliminada con metadata para presentacion.
 *
 * @package App\Application\Configuracion\DTOs
 */
final readonly class CuentaDeletedDTO
{
    /**
     * @param string $id
     * @param string|null $nombre
     * @param float $saldo_inicial
     * @param float $saldo_actual
     * @param string|null $deleted_at
     * @param bool $can_hard_delete
     */
    public function __construct(
        public string $id,
        public ?string $nombre,
        public float $saldo_inicial,
        public float $saldo_actual,
        public ?string $deleted_at,
        public bool $can_hard_delete
    ){
    }
}
