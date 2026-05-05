<?php

namespace App\Application\Reporte\Queries\Handlers;

use App\Application\Reporte\Queries\ListReporteFormOptionsQuery;
use App\Shared\Application\Contracts\Queries\QueryExecutors\FormOptions\ListCuentaForFormContract;
use App\Shared\Application\Contracts\Queries\QueryExecutors\FormOptions\ListCategoriaForFormContract;
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
         * @var CategoriaForFormCollectionContract
         */
        $categorias = $this->categoriaForForm->execute();
        $cuentas = $this->cuentaForForm->execute();
        return new ReporteFormOptionsDTO(
            categorias: $categorias,
            cuentas: $cuentas
        );
        
    }
}