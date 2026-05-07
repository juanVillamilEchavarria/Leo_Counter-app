<?php

namespace App\Shared\Application\Queries;
use App\Shared\Application\Contracts\Queries\QueryContract;
/**
 * Query que representa los filtros de una tabla.
 * @property string|null $search
 * @property int|null $perPage
 * @property string|null $sortBy
 * @property string|null $sortOrder
 * @property int|null $page
 */
abstract readonly class TableQuery implements QueryContract {
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