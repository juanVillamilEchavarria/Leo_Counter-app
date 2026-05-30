<?php

namespace App\Shared\Domain\Enums;

/**
 * Enum que se encarga de representar los operadores de comparacion que se pueden utilizar en las consultas, cada valor del enum corresponde a un operador de comparacion que se puede utilizar en las consultas, el valor del enum es el simbolo del operador de comparacion que se va a utilizar en la consulta
 * @example ComparativeOperators::EQUALS->value // devuelve '='
 */
enum ComparativeOperators : string {
    case EQUALS = '=';
    case GREATER_THAN = '>';
    case LESS_THAN = '<';
    case GREATER_THAN_OR_EQUAL = '>=';
    case LESS_THAN_OR_EQUAL = '<=';
    case NOT_EQUALS = '!=';

    /** metodo que se encarga de validar si un valor es un valor valido del enum, recibe un string y devuelve un boolean indicando si el string es un valor valido del enum o no
     * @param string $value
     * @return bool
     */
    public static function isValid (string $value) : bool {
        return in_array($value, self::cases());
    }
}
