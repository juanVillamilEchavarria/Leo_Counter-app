<?php
namespace App\Shared\DTOs\Querys;
use App\Shared\Enums\ComparativeOperators;
use Illuminate\Support\Carbon;
/**
 * DTO que se encarga de representar los datos necesarios para realizar una consulta con filtros, recibe el nombre de la columna por la cual se va a filtrar, el operador de comparacion, el valor por el cual se va a filtrar y la logica de la consulta (and o or)
 * @package App\Shared\DTOs\Querys
 * @param string $column -  columna por la cual se va a filtrar, debe ser un string que corresponda al nombre de una columna en la base de datos
 * @param ComparativeOperators $operator - operador de comparacion, debe ser un valor del enum ComparativeOperators que corresponda al operador de comparacion que se va a utilizar en la consulta
 * @param string|int|float|bool|null|Carbon $value - valor por el cual se va a filtrar, debe ser un valor que corresponda al tipo de dato que corresponda al operador de comparacion que se va a utilizar en la consulta
 * @param string $logic - logica de la consulta (and o or), debe ser un string que corresponda a la logica de la consulta que se va a utilizar en la consulta, por defecto es 'and'
 */
final class WhereFilterQueryDTO{
    public function __construct(
        public readonly string $column,
        public readonly ComparativeOperators $operator,
        public readonly string | int | float | bool | null | Carbon $value,
        public readonly string $logic = 'and'
    )
    {
    }
}