<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
