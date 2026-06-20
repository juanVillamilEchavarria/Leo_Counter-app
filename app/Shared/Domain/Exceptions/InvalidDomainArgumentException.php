<?php

namespace App\Shared\Domain\Exceptions;

use App\Shared\Domain\Exceptions\ClientFacingException;
use App\Shared\Domain\Exceptions\DomainException;

class InvalidDomainArgumentException extends DomainException implements ClientFacingException
{

}
