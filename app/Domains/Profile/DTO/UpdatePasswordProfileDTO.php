<?php

namespace App\Domains\Profile\DTO;
use App\Shared\Abstracts\DTOs\DTO;
use App\Domains\Profile\DTO\Contracts\ProfileDTOContract;
use App\Shared\ValueObjects\Password;

class UpdatePasswordProfileDTO extends DTO implements ProfileDTOContract{

    protected array $except = [
        'current_password',
    ];
    public function __construct(
        public readonly string $current_password,
        public readonly Password $password,
    )
    {
        
    }

}