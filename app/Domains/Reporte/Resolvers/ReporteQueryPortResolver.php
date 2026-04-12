<?php

namespace App\Domains\Reporte\Resolvers;

use App\Domains\Reporte\Contracts\Ports\ReporteQueryPort;
use App\Domains\Reporte\Enums\Domains\DomainReportQueryType;
use App\Domains\Reporte\Exceptions\CannotResolveRepositoryException;

final class ReporteQueryPortResolver
{
    public function __construct(
        /** @var iterable<ReporteQueryPort> */
        private iterable $repositories
    ) {}

    public function resolve(DomainReportQueryType $type): ReporteQueryPort
    {
        foreach ($this->repositories as $repository) {
            if ($repository->supports($type)) {
                return $repository;
            }
        }
        throw new CannotResolveRepositoryException(
            "No repository found for type: {$type->value}"
        );
    }
}