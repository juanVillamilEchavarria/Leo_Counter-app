<?php

namespace App\Infrastructure\Reporte\Contracts\Enums;

/**
 * Contrato para los enums que definen los parametros de las relaciones por consultas, para que mediante este, se pueda implementar la estrategia correcta de relacion y construir la query correspondiente y el filtrado correcto
 * Cada dominio integrado en reportes, debe definir su propio enum que extienda esta interfaz
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
interface QueryRelationParamContract
{
    // value() esta implicito en los enums de php
}