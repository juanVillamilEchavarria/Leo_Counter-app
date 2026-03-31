<?php

namespace App\Domains\Profile\Strategies\Resolvers;
use App\Domains\Profile\Specifications\Contracts\ProfileDTOSpecificationContract;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Models\User;

class UpdateProfileSectionValidateResolver{
    public function __construct(
        /**
         * @var UpdateProfileSectionValidateStrategyContract[]
         */
        private iterable $strategies
    )
    {
    }

    public function resolve(ProfileDTOContract $dto, User $user): ProfileDTOContract{
        foreach($this->strategies as $strategy){
            if($strategy->supports($dto)){
                $dto = $strategy->apply($dto, $user);
            }
        }
        return $dto;
    }


}