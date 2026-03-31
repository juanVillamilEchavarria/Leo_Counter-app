<?php

namespace App\Domains\Profile\DTO;
use App\Shared\Abstracts\DTOs\DTO;
use App\Shared\ValueObjects\Email;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;

class UpdateProfileDTO extends DTO implements ProfileDTOContract {

    public function __construct(
        public readonly ?string $name ,
        public readonly ?Email $email,
    )
    {
        
    }

}