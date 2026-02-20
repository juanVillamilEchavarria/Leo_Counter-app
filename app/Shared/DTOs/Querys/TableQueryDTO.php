<?php

namespace App\Shared\DTOs\Querys;

use App\Shared\Abstracts\DTOs\DTO;

final class TableQueryDTO extends DTO{
    public function __construct(
        public ?string $search = null,
        public ?int $perPage = null,
        public ?string $sortBy = null,
        public ?string $sortOrder = 'asc',
        public ?int $page = null
    )
    {
    }
}