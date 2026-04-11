<?php

namespace App\Domains\Reporte\Resolvers;

use App\Domains\Reporte\Contracts\Repositories\ReporteModelRepositoryContract;
use App\Domains\Reporte\Enums\ReporteRepositoryType;
use App\Domains\Reporte\Exceptions\CannotResolveRepositoryException;

final class ReporteRepositoryResolver
{
    public function __construct(
        /** @var iterable<ReporteModelRepositoryContract> */
        private iterable $repositories
    ) {}

    public function resolve(ReporteRepositoryType $type): ReporteModelRepositoryContract
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