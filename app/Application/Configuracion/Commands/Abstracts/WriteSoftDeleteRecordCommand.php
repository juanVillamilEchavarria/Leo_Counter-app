<?php

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
