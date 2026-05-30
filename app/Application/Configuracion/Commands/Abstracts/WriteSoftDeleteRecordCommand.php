<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Configuracion\Commands\Abstracts;

abstract readonly  class WriteSoftDeleteRecordCommand
{
    /**
     * @param string $id - id del registro
     * @param string $domain - el dominio del registro, ejemplo Categorias
     */

    public function __construct(
        public string $id,
        public \App\Domains\Configuracion\Enums\SoftDeleteManagerTypes $domain
    )
    {
    }

}
