<?php

namespace App\Domains\ArchivoMovimiento\ValueObjects;

use App\Shared\Domain\Contracts\AggregateModelIdContract;
use App\Shared\Domain\ValueObjects\Abstracts\DomainId;

final readonly class ArchivoMovimientoId extends DomainId implements AggregateModelIdContract
{
}
