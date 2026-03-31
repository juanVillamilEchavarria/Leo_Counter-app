<?php

namespace App\Shared\DTOs\Querys;

use App\Shared\Abstracts\DTOs\DTO;

/**
 * DTO que se encarga de representar los datos necesarios para realizar una consulta de ids
 */
class IdsDTO extends DTO
{
    public function __construct(
        /** @var array<int> */
        public readonly array $ids
    )
    {
    }

    public static function fromArray(array $data): static
    {
        $ids = [];
        foreach($data as $d){
            $ids[] = $d['id'];
        }
       return new static($ids);
    }
}