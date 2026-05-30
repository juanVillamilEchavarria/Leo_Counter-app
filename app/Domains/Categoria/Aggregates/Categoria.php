<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\Categoria\Aggregates;

use App\Domains\Categoria\Contracts\CategoriaUniquenessCheckerContract;
use App\Domains\Categoria\Exceptions\CannotStoreCategoriaException;
use App\Domains\Categoria\Exceptions\CannotUpdateCategoriaException;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\AggregateModelContract;

/**
 * Agregado raíz del dominio Categoría.
 * Representa una categoría de movimientos con nombre, tipo y descripción opcional.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\Categoria\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Categoria implements AggregateModelContract
{
    private function __construct(
        private CategoriaId $id,
        private string $nombre,
        private int $tipo_movimiento_id,
        private ?string $descripcion = null
    ) {
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
        CategoriaId $id,
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion,
        CategoriaUniquenessCheckerContract $checker
    ): self {
        if ($checker->exists($nombre, $tipo_movimiento_id)) {
            throw new CannotStoreCategoriaException(
                message: "La categoría con nombre $nombre y tipo de movimiento $tipo_movimiento_id ya existe."
            );
        }
        return new self(
            id: $id,
            nombre: $nombre,
            tipo_movimiento_id: $tipo_movimiento_id,
            descripcion: $descripcion
        );
    }
    /**
     * Reconstituye (hidrata) una instancia de la clase Categoria a partir de sus atributos.
     * @param string $nombre El nombre de la categoría.
     * @param int $tipo_movimiento_id El identificador del tipo de movimiento asociado a la categoría.
     * @param string|null $descripcion Una descripción opcional de la categoría.
     * @return self La instancia reconstituida de la clase Categoria.
     */

    public static function reconstitute(
        CategoriaId $id,
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion
    ): self
    {
        return new self(
            id: $id,
            nombre: $nombre,
            tipo_movimiento_id: $tipo_movimiento_id,
            descripcion: $descripcion
        );
    }
    public function updateData(
        string $nombre,
        int $tipo_movimiento_id,
        ?string $descripcion,
        CategoriaUniquenessCheckerContract $checker
    ): self {
        if ($checker->exists($nombre, $tipo_movimiento_id, $this->id->getValue())) {
            throw new CannotUpdateCategoriaException(
                message: "La categoría con nombre $nombre y tipo de movimiento $tipo_movimiento_id ya existe."
            );
        }
        return new self(
            id: $this->id,
            nombre: $nombre,
            tipo_movimiento_id: $tipo_movimiento_id,
            descripcion: $descripcion
        );
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

    /**
     * Retorna la identidad única de la categoría.
     *
     * @return CategoriaId Identidad de la categoría (UUID v7)
     */
    public function getId(): CategoriaId
    {
        return $this->id;
    }
}