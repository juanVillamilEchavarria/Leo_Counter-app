<?php

namespace App\Application\Categoria\Commands;

final readonly class DestroyCategoryCommand
{
    public function __construct(
        public string $id
    )
    {
    }
}