<?php

namespace App\Shared\Domain\ValueObjects;
use App\Shared\Domain\ValueObjects\Abstracts\ValueObject;

/**
 * DTO que se encarga de representar los datos necesarios para realizar una consulta de ids
 */
class Ids extends ValueObject
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