<?php

namespace App\Domains\Profile\Specifications\Contracts;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
interface ProfileDTOSpecificationContract{
    public function isSatisfiedBy(array $data): bool;
    public function buildDTO(array $data): ProfileDTOContract;
}