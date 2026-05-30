<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Categoria\Exceptions;

use App\Domains\Categoria\Exceptions\CategoriaException;

class CannotUpdateCategoriaException extends CategoriaException
{
    public function __construct($message = 'No se puede actualizar la categoria')
    {
        parent::__construct($message);
    }
}
