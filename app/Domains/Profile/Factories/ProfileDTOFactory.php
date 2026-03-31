<?php 
namespace App\Domains\Profile\Factories;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;

class ProfileDTOFactory {

    public function __construct(
        /**
         * @var ProfileDTOSpecificationContract[]
         */
        private iterable $specifications

    )
    {
    }

    public function make(array $data): ProfileDTOContract{
        foreach($this->specifications as $specification){
            if($specification->isSatisfiedBy($data)){
                return $specification->buildDTO($data);
            }
        }
        throw new \InvalidArgumentException('No se pudo determinar el tipo de DTO a construir con los datos proporcionados.');
    }
}
