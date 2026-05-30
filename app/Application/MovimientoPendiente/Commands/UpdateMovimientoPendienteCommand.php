<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\MovimientoPendiente\Commands;

use App\Application\MovimientoPendiente\Commands\Abstracts\WriteMovimientoPendienteCommand;

/**
 * Comando que representa la intencion de actualizar un movimiento pendiente existente.
 * Incluye la identidad del agregado y los datos primitivos que seran transformados en VOs por el handler.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoPendiente\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class UpdateMovimientoPendienteCommand extends WriteMovimientoPendienteCommand
{
    public function __construct(
        public string $id,
        string $categoria_id,
        int $tipo_movimiento_id,
        string $cuenta_id,
        string $nombre,
        float $monto,
        string $fecha_programada,
        ?int $dias_aviso = null,
        ?string $descripcion = null,
    ) {
        parent::__construct(
            categoria_id: $categoria_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            cuenta_id: $cuenta_id,
            nombre: $nombre,
            monto: $monto,
            fecha_programada: $fecha_programada,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
        );
    }
}
