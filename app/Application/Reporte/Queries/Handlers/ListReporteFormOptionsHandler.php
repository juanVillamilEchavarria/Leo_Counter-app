<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\Queries\Handlers;

use App\Application\Reporte\Queries\ListReporteFormOptionsQuery;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\Executors\FormOptions\ListCategoriaForFormContract;
use App\Application\Reporte\DTOs\Form\ReporteFormOptionsDTO;
use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;

final readonly class ListReporteFormOptionsHandler{
    public function __construct(
        private ListCuentaForFormContract $cuentaForForm,
        private ListCategoriaForFormContract $categoriaForForm
    )
    {
    }

    public function __invoke( ListReporteFormOptionsQuery $query ): ReporteFormOptionsDTO
    {
        /**
         * @var CategoriaForFormCollectionContract $categorias
         */
        $categorias = $this->categoriaForForm->execute();
        $cuentas = $this->cuentaForForm->execute();
        return new ReporteFormOptionsDTO(
            categorias: $categorias,
            cuentas: $cuentas
        );

    }
}
