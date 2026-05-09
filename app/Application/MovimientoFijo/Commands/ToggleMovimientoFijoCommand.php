<?php

namespace App\Application\MovimientoFijo\Commands;

/**
 * Comando que representa la intencion de alternar un atributo booleano de MovimientoFijo.
 * El repositorio valida que el atributo solicitado este permitido antes de persistir el cambio.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\MovimientoFijo\Commands
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ToggleMovimientoFijoCommand
{
    public function __construct(
        public string $id,
        public string $attribute,
    ) {
    }
}
