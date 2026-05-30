<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Shared\Application\Contracts\Bus;

/**
 * Interfaz que define el comportamiento de un despachador de comandos usado en la capa de aplicacion.
 * los handlers que necesiten llamar a otros, deben inyectar este contrato y usar su dispatch.
 * @package App\Shared\Application\Contracts\Bus
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface CommandBus
{
    /**
     * Despacha un handler asociado a un comando
     * @param $command - comando
     * @return mixed
     */
    public function dispatch($command): mixed;

}
