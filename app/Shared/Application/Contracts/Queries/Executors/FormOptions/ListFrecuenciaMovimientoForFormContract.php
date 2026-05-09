<?php

namespace App\Shared\Application\Contracts\Queries\Executors\FormOptions;

use App\Shared\Application\Contracts\Queries\Executors\FormOptions\Abstracts\ListForFormContract;

/**
 * Contrato para listar frecuencias de movimiento como opciones de formulario.
 * Permite reutilizar la consulta desde modulos que necesiten configurar recurrencias.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Shared\Application\Contracts\Queries\Executors\FormOptions
 * @since 1.0.0
 * @version 1.0.0
 */
interface ListFrecuenciaMovimientoForFormContract extends ListForFormContract
{
}
