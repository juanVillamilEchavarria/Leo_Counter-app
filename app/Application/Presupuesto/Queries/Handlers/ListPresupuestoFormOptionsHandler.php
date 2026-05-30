<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Presupuesto\Queries\Handlers;

use App\Application\Presupuesto\Queries\ListPresupuestoFormOptionsQuery;
use App\Application\Presupuesto\DTOs\PresupuestoFormOptionsDTO;
use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;

/**
 * Handler encargado de manejar la consulta para obtener las opciones necesarias para los formularios relacionados con presupuestos.
 * Este handler recibe un query de tipo ListPresupuestoFormOptionsQuery y utiliza un executor para ejecutar la consulta y obtener el resultado.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Application\Presupuesto\Queries\Handlers
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class ListPresupuestoFormOptionsHandler
{
    public function __construct(
        private ListCategoriaForFormContract $executor
    ) {}

    public function __invoke(ListPresupuestoFormOptionsQuery $query): PresupuestoFormOptionsDTO
    {

       return new PresupuestoFormOptionsDTO(
       /**
        * @var CategoriaForFormCollectionContract
        */
        categorias: $this->executor->execute()->gastos()
       );
    }
}
