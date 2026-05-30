<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Configuracion\Strategies;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Configuracion\Contracts\Checkers\DomainRecordCanBeDeletedCheckerContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Domains\Configuracion\Contracts\Strategies\SoftDeleteManagerContract;
use App\Domains\Configuracion\Enums\SoftDeleteManagerTypes;
use App\Domains\Configuracion\Strategies\Abstracts\SoftDeleteManager;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Manager de persistencia para registros eliminados de Categoría.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Configuracion\Strategies
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class SoftDeleteCategoriaManager extends SoftDeleteManager implements SoftDeleteManagerContract{
    public function __construct(
        private DomainRecordCanBeDeletedCheckerContract $domainRecordCanBeDeletedCheckerContract,
        CategoriaRepositoryContract $writeRepository
    ) {
        parent::__construct($writeRepository);
    }
    protected function normalizeId(string $id): AggregateModelIdContract
    {
        return new CategoriaId($id);
    }

    public function supports(SoftDeleteManagerTypes $domainType): bool
    {
        return $domainType === SoftDeleteManagerTypes::CATEGORIAS;
    }

    public function canDelete(AggregateModelIdContract $id): bool
    {
       return $this->domainRecordCanBeDeletedCheckerContract->canBeDeleted($id);
    }

}
