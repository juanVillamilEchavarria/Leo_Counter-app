<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.1
 */
namespace App\Domains\Presupuesto\Aggregates;

use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoCanDuplicateCheckerContract;
use App\Domains\Presupuesto\Contracts\Checkers\PresupuestoUniquenessCheckerContract;
use App\Domains\Usuario\ValueObjects\UsuarioId;
use App\Domains\Presupuesto\ValueObjects\PresupuestoId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Shared\Domain\Contracts\PrimitiveAggregateModelContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use Throwable;

/**
 * Agregado de dominio Presupuesto.
 * Representa un presupuesto del sistema con su información.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class Presupuesto implements PrimitiveAggregateModelContract
{
    private function __construct(
        private PresupuestoId $id,
        private CategoriaId   $categoria_id,
        private Amount        $monto,
        private Date          $periodo,
        private ?string       $descripcion,
        private UsuarioId        $user_id,
    ) {
    }
    /**
     * Crea un nuevo presupuesto.
     */

    public static function create(
        PresupuestoId $id,
        CategoriaId $categoria_id,
        Amount $monto,
        Date $periodo,
        ?string $descripcion,
        UsuarioId $user_id,
        PresupuestoUniquenessCheckerContract $checker
    ): self {
        if(!$checker->isUnique($categoria_id, $periodo->format('Y-m'))) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException(
                message: 'Ya existe un presupuesto para la fecha seleccionada'
            );
        }
            self::validateData($monto, \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException::class);
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $periodo,
            descripcion: $descripcion,
            user_id: $user_id,
        );
    }
    /**
     * Reconstituye un presupuesto existente.
     * No aplica validaciones
     */

    public static function reconstitute(
        PresupuestoId $id,
        CategoriaId $categoria_id,
        Amount $monto,
        Date $periodo,
        ?string $descripcion,
        UsuarioId $user_id
    ): self {
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $periodo,
            descripcion: $descripcion,
            user_id: $user_id,
        );
    }

    /**
     * Actualiza los datos de un presupuesto existente
     */
    public function updateData(
        CategoriaId $categoria_id,
        Amount $monto,
        ?string $descripcion,
        PresupuestoUniquenessCheckerContract $checker
    ): self {
        if (!$checker->isUnique($categoria_id, $this->periodo->format('Y-m'), $this->id)) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException(
                message: 'Ya existe un presupuesto para esta categoria en la fecha seleccionada'
            );
        }
            self::validateData($monto, \App\Domains\Presupuesto\Exceptions\CannotUpdatePresupuestoException::class);

        return new self(
            id: $this->id,
            categoria_id: $categoria_id,
            monto: $monto,
            periodo: $this->periodo,
            descripcion: $descripcion,
            user_id: $this->user_id,
        );
        
    }
    /**
     * Valida los datos obligatorios del presupuesto
     * @param Amount $monto
     * @param string|null $exceptionClass
      * @throws Throwable
     */
    public static function validateData( Amount $monto, string $exceptionClass): void
    {
        if ($monto->isLessOrEqualThanCero()) {
            throw new $exceptionClass(
                message: 'El monto del presupuesto no puede ser cero o negativo'
            );
        }
    }
    /**
     * Duplica un presupuesto
     */

    public function duplicate( PresupuestoId $id,PresupuestoCanDuplicateCheckerContract $checker): self
    {
        if (!$checker->canDuplicate($this->categoria_id, $this->periodo->format('Y-m'))) {
            throw new \App\Domains\Presupuesto\Exceptions\CannotStorePresupuestoException(
                message: 'Ya existe un presupuesto duplicado para este'
            );
        }

        return new self(
            id: $id,
            categoria_id: $this->categoria_id,
            monto: $this->monto,
            periodo: $this->periodo->addMonths(),
            descripcion: $this->descripcion,
            user_id: $this->user_id,
        );
    }
    public function toPrimitive(): array
    {
        return [
            'id' => $this->id->getValue(),
            'categoria_id' => $this->categoria_id->getValue(),
            'monto' => $this->monto->getValue(),
            'periodo' => $this->periodo->format('Y-m'),
            'descripcion' => $this->descripcion,
            'user_id' => $this->user_id->getValue(),
        ];
    }

    public function getId(): PresupuestoId
    {
        return $this->id;
    }
    /**
     * Retorna la identidad de la categoria asociada al presupuesto.
     *
     * @return CategoriaId
     */
    public function getCategoriaId(): CategoriaId
    {
        return $this->categoria_id;
    }

    public function getMonto(): Amount
    {
        return $this->monto;
    }

    public function getPeriodo(): Date
    {
        return $this->periodo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getUserId(): UsuarioId
    {
        return $this->user_id;
    }
}
