<?php
/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Domains\Auditoria\Contracts\Repositories;

use App\Domains\Auditoria\Aggregates\Auditoria;
use App\Domains\Auditoria\ValueObjects\AuditoriaId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Contrato del repositorio de Auditoria
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 */
interface AuditoriaRepositoryContract
{
    /**
     * Almacena un auditoria
     * @param Auditoria $auditoria
     * @return Auditoria
     */
    public function store( AggregateModelContract $auditoria ): AggregateModelContract;

    /**
     * Busca un auditoria por su id
     * @param AuditoriaId $id
     * @return Auditoria|null
     */
    public function findById( AggregateModelIdContract $id ): ?AggregateModelContract;

}
