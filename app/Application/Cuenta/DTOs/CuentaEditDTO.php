<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Cuenta\DTOs;
/**
 * DTO que representa los datos necesarios para editar una cuenta.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Cuenta\DTOs
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class CuentaEditDTO{
    public function __construct(
         public string $id,
        public string $nombre,
        public ?string $notas,
        public float $saldo_inicial,
        public string $propietario_id,
        public int $tipo_cuenta_id,
        public bool $can_update_saldo,
    )
     {
    }
}
