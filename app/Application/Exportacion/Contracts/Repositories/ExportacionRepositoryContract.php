<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.1.0
 * @version 1.1.0
 */

namespace App\Application\Exportacion\Contracts\Repositories;

use App\Domains\Exportacion\Enums\ExportableTable;
use App\Domains\Exportacion\Enums\ExportFormat;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\Contracts\AggregateModelIdContract;

/**
 * Contrato del repositorio de logging de exportaciones.
 * Registra cada exportación realizada por un usuario (logging operativo, sin eventos).
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 *
 * @since 1.1.0
 *
 * @version 1.1.0
 */
interface ExportacionRepositoryContract
{
   public function store(AggregateModelContract $aggregate): AggregateModelContract;

   public function destroy(AggregateModelIdContract $id): bool;

   public function findById(AggregateModelIdContract $id): ?AggregateModelContract;
}
