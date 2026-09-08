<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Reporte\ValueObjects\Budget;

use App\Shared\Domain\Exceptions\InvalidDomainArgumentException;
use App\Shared\Domain\Services\Financial\PercentageService;

/**
 * Value Object para representar el presupuestado utilizado en un periodo específico.
 * Contiene el total del presupuestado asignado, el total de gastado realizados y el presupuestado disponible.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
final readonly class UsedBudgetVO
{
    public string $categoria;
        public float $presupuestado;
        public float $gastado;
        public float $disponible;
        public float $porcentaje_usado;
    /**
     * @param float $presupuestado El total del presupuestado asignado para el periodo.
     * @param float $gastado El total de gastado realizados en el periodo.
     * @param float $disponible calculado como presupuestado - gastado, puede ser negativo si se han excedido los gastado.
     */
    public function __construct(
        string $categoria,
         float $presupuestado,
         float $gastado,
         float $disponible
        
    ) {
        self::validate($presupuestado, $gastado, $disponible);
        $this->categoria = $categoria;
        $this->presupuestado = $presupuestado;
        $this->gastado = $gastado;
        $this->disponible = $disponible;
        $this->porcentaje_usado = min(100,(new PercentageService())->calculatePercentage($this->gastado, $this->presupuestado));
    }


    private static function validate( 
        float $presupuestado,
        float $gastado,
        float $disponible
    ): void {
        if ($presupuestado < 0) {
            throw new InvalidDomainArgumentException('El total del presupuestado no puede ser negativo.');
        }
        if ($gastado < 0) {
            throw new InvalidDomainArgumentException('El total de gastado no puede ser negativo.');
        }
        if ($disponible < 0) {
            throw new InvalidDomainArgumentException('El presupuestado disponible no puede ser negativo.');
        }
    }
}