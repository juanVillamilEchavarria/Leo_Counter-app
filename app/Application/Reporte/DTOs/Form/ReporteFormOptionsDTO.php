<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Reporte\DTOs\Form;

use App\Shared\Domain\Contracts\CollectionContract;
use App\Shared\Application\Contracts\Collections\FormOptions\CategoriaForFormCollectionContract;

final readonly class ReporteFormOptionsDTO {
    public function __construct(
        public  CategoriaForFormCollectionContract $categorias,
        public  CollectionContract $cuentas
    )
    {
    }
}
