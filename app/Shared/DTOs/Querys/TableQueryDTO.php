<?php

namespace App\Shared\Domain\ValueObjects;

use App\Shared\Abstracts\DTOs\DTO;
/**
 * DTO que se encarga de representar los datos necesarios para realizar una consulta de tablas,recibe el termino de busqueda, la cantidad de resultados por pagina, el campo por el cual se va a ordenar, el orden de la ordenacion y la pagina actual
 * @property string|null $search
 * @property int|null $perPage
 * @property string|null $sortBy
 * @property string|null $sortOrder
 * @property int|null $page
 */
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