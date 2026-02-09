<?php
namespace App\Shared\DTOs;
use App\Shared\Enums\ComparativeOperators;
final class WhereFilterQueryDTO{
    public function __construct(
        public readonly string $column,
        public readonly ComparativeOperators $operator,
        public readonly string | int | float | bool | null $value
    )
    {
    }
}