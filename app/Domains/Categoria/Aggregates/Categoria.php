<?php

namespace App\Domains\Categoria\Aggregates;

use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Shared\Abstracts\Exceptions\DomainException;
use App\Shared\Domain\Contracts\AggregateModelContract;

final readonly class Categoria implements AggregateModelContract{
    private function __construct(
        /**
         * @param string $nombre El nombre de la categoría. Este atributo es esencial para identificar la categoría y debe ser único dentro del sistema.
         * @param int $tipo_movimiento_id El identificador del tipo de movimiento asociado a la categoría. Este atributo es crucial para clasificar la categoría dentro de un tipo específico de movimiento, como ingresos o gastos.
         * @param string|null $descripcion Una descripción opcional de la categoría
         * @param CategoriaUniquenessCheckerContract $categoriaUniquenessChecker Un servicio que se utiliza para verificar la unicidad de la categoría antes de su creación o actualización, asegurando que no existan categorías duplicadas en el sistema.
         */
        private string $nombre,
        private int $tipo_movimiento_id,
        private ?string $descripcion = null
    )
    {
    }

    /**
     * Crea una nueva instancia de la clase Categoria.
     * Verifica si ya existe una categoría con el mismo nombre y tipo de movimiento antes de crearla.
     * @param string $nombre El nombre de la categoría.
     * @param int $tipo_movimiento_id El identificador del tipo de movimiento asociado a la categoría.
     * @param string|null $descripcion Una descripción opcional de la categoría.
     * @param CategoriaUniquenessCheckerContract $checker Un servicio que se utiliza para verificar la unicidad de la categoría.
     * @return self La nueva instancia de la clase Categoria.
     */
    public static function create(
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion,
        CategoriaUniquenessCheckerContract $checker
    ): self {
        if ($checker->exists($nombre, $tipo_movimiento_id)) {
            throw new DomainException("La categoría con nombre $nombre y tipo de movimiento $tipo_movimiento_id ya existe.");
        }
        return new self($nombre, $tipo_movimiento_id, $descripcion);
    }
    /**
     * Reconstituye (hidrata) una instancia de la clase Categoria a partir de sus atributos.
     * @param string $nombre El nombre de la categoría.
     * @param int $tipo_movimiento_id El identificador del tipo de movimiento asociado a la categoría.
     * @param string|null $descripcion Una descripción opcional de la categoría.
     * @return self La instancia reconstituida de la clase Categoria.
     */

    public  static function reconstitute(
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion
    ): self
    {
        return new self($nombre, $tipo_movimiento_id, $descripcion);
        
    }
        /**
     * Actualiza los datos de la categoría.
     * Verifica si ya existe una categoría con el mismo nombre y tipo de movimiento antes de actualizarla.
     * @param string $nombre El nombre de la categoría.
     * @param int $tipo_movimiento_id El identificador del tipo de movimiento asociado a la categoría.
     * @param string|null $descripcion Una descripción opcional de la categoría.
     * @param CategoriaUniquenessCheckerContract $checker Un servicio que se utiliza para verificar la unicidad de la categoría.
     * @return self La nueva instancia de la clase Categoria.
     */
    public function updateData(
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion,
        CategoriaUniquenessCheckerContract $checker,
        int $id
    ): self {
        if ($checker->exists($nombre, $tipo_movimiento_id, $id)) {
            throw new DomainException("La categoría con nombre $nombre y tipo de movimiento $tipo_movimiento_id ya existe.");
        }
        return new self($nombre, $tipo_movimiento_id, $descripcion);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getTipoMovimientoId(): int
    {
        return $this->tipo_movimiento_id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }
}