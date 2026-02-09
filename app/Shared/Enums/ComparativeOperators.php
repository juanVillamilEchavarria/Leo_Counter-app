<?php

namespace App\Shared\Enums;

enum ComparativeOperators : string {
    case EQUALS = '=';
    case GREATER_THAN = '>';
    case LESS_THAN = '<';
    case GREATER_THAN_OR_EQUAL = '>=';
    case LESS_THAN_OR_EQUAL = '<=';
    case NOT_EQUALS = '!=';

    public static function isValid (string $value) : bool {
        return in_array($value, self::cases());
    }
}