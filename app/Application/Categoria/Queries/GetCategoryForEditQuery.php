<?php

namespace App\Application\Categoria\Queries;
use App\Shared\Application\Contracts\Queries\QueryContract;
/**
 * Query que representa la intención de obtener los datos necesarios para editar una categoría específica.
 * Este query se utiliza para consultas que requieren la información de una categoría en particular, identificada por su ID, para ser editada en un formulario.
 * Implementa el contrato QueryContract para ser compatible con los query executors que manejan consultas generales.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Categoria\Queries
 * @since 1.0.0
 */
final readonly class GetCategoryForEditQuery implements QueryContract{
    public function __construct(
        public string $id
    )
    {
    }
}