<?php

namespace App\Domains\MovimientoPendiente\Aggregates;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Domains\MovimientoPendiente\Exceptions\CannotStoreMovimientoPendienteException;
use App\Domains\MovimientoPendiente\Exceptions\CannotUpdateMovimientoPendienteException;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Date;

/**
 * Agregado raiz del dominio MovimientoPendiente.
 * Representa un movimiento pendiente configurado por el usuario, con sus relaciones
 * de categoria, cuenta, tipo de movimiento y frecuencia, ademas de los datos de programacion.
 * El usuario puede crear manualmente un movimiento pendiente, o bien puede ser instanciado automaticamente por el sistema mediante un movimiento fijo.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @package App\Domains\MovimientoPendiente\Aggregates
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class MovimientoPendiente implements AggregateModelContract
{
    private function __construct(
        private MovimientoPendienteId      $id,
        private CategoriaId                $categoria_id,
        private CuentaId                   $cuenta_id,
        private ?MovimientoFijoId          $movimiento_fijo_id,
        private int                        $tipo_movimiento_id,
        private string                     $nombre,
        private float                      $monto,
        private Date                       $fecha_programada,
        private ?int                       $dias_aviso,
        private ?string                    $descripcion,
        private EstadosMovimientoPendiente $estado,
    )
    {
    }

    /**
     * Crea un nuevo movimiento pendiente aplicando sus invariantes de negocio.
     *
     * @param MovimientoPendienteId $id Identidad del movimiento pendiente.
     * @param CategoriaId $categoria_id Identidad de la categoría.
     * @param CuentaId $cuenta_id Identidad de la cuenta.
     * @param int $tipo_movimiento_id Identificador del tipo de movimiento.
     * @param string $nombre Nombre descriptivo.
     * @param float $monto Monto del movimiento.
     * @param Date $fecha_programada Fecha en la que se programa realizar el movimiento.
     * @param int|null $dias_aviso Días de aviso previo.
     * @param string|null $descripcion Descripción opcional.
     * @param EstadosMovimientoPendiente|null $estado Estado inicial (por defecto Pendiente).
     * @param MovimientoFijoId|null $movimiento_fijo_id Movimiento fijo de origen.
     * @return self
     */
    public static function create(
        MovimientoPendienteId       $id,
        CategoriaId                 $categoria_id,
        CuentaId                    $cuenta_id,
        int                         $tipo_movimiento_id,
        string                      $nombre,
        float                       $monto,
        Date                        $fecha_programada,
        ?int                        $dias_aviso = null,
        ?string                     $descripcion = null,
        ?EstadosMovimientoPendiente $estado = null,
        ?MovimientoFijoId           $movimiento_fijo_id = null,
    ): self
    {
        self::validateData($nombre, $monto, $tipo_movimiento_id, $dias_aviso, CannotStoreMovimientoPendienteException::class);

        return new self(
            id: $id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            movimiento_fijo_id: $movimiento_fijo_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_programada: $fecha_programada,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            estado: $estado ?? EstadosMovimientoPendiente::PENDIENTE,
        );
    }

    /**
     * Reconstituye un movimiento pendiente desde la persistencia.
     */
    public static function reconstitute(
        MovimientoPendienteId      $id,
        CategoriaId                $categoria_id,
        CuentaId                   $cuenta_id,
        ?MovimientoFijoId          $movimiento_fijo_id,
        int                        $tipo_movimiento_id,
        string                     $nombre,
        float                      $monto,
        Date                       $fecha_programada,
        ?int                       $dias_aviso,
        ?string                    $descripcion,
        EstadosMovimientoPendiente $estado,
    ): self
    {
        return new self(
            id: $id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            movimiento_fijo_id: $movimiento_fijo_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_programada: $fecha_programada,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            estado: $estado,
        );
    }

    /**
     * Actualiza los datos editables del movimiento pendiente.
     */
    public function updateData(
        CategoriaId $categoria_id,
        CuentaId    $cuenta_id,
        int         $tipo_movimiento_id,
        string      $nombre,
        float       $monto,
        Date        $fecha_programada,
        ?int        $dias_aviso,
        ?string     $descripcion,
    ): self
    {
        self::validateData($nombre, $monto, $tipo_movimiento_id, $dias_aviso, CannotUpdateMovimientoPendienteException::class);

        return new self(
            id: $this->id,
            categoria_id: $categoria_id,
            cuenta_id: $cuenta_id,
            movimiento_fijo_id: $this->movimiento_fijo_id,
            tipo_movimiento_id: $tipo_movimiento_id,
            nombre: $nombre,
            monto: $monto,
            fecha_programada: $fecha_programada,
            dias_aviso: $dias_aviso,
            descripcion: $descripcion,
            estado: $this->estado,
        );
    }

    /**
     * Cambia el estado del movimiento a "Realizado".
     */
    public function markAsDone(): self
    {
        return new self(
            id: $this->id,
            categoria_id: $this->categoria_id,
            cuenta_id: $this->cuenta_id,
            movimiento_fijo_id: $this->movimiento_fijo_id,
            tipo_movimiento_id: $this->tipo_movimiento_id,
            nombre: $this->nombre,
            monto: $this->monto,
            fecha_programada: $this->fecha_programada,
            dias_aviso: $this->dias_aviso,
            descripcion: $this->descripcion,
            estado: EstadosMovimientoPendiente::REALIZADO,
        );
    }

    /**
     * Marca el movimiento como vencido.
     */
    public function markAsExpired(): self
    {
        return new self(
            id: $this->id,
            categoria_id: $this->categoria_id,
            cuenta_id: $this->cuenta_id,
            movimiento_fijo_id: $this->movimiento_fijo_id,
            tipo_movimiento_id: $this->tipo_movimiento_id,
            nombre: $this->nombre,
            monto: $this->monto,
            fecha_programada: $this->fecha_programada,
            dias_aviso: $this->dias_aviso,
            descripcion: $this->descripcion,
            estado: EstadosMovimientoPendiente::VENCIDO,
        );
    }

    private static function validateData(
        string $nombre,
        float  $monto,
        int    $tipo_movimiento_id,
        ?int   $dias_aviso,
        string $exceptionClass,
    ): void
    {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre del movimiento pendiente es obligatorio.');
        }

        if ($monto < 0) {
            throw new $exceptionClass('El monto del movimiento pendiente no puede ser negativo.');
        }

        if ($tipo_movimiento_id <= 0) {
            throw new $exceptionClass('El tipo de movimiento es obligatorio.');
        }

        if ($dias_aviso !== null && $dias_aviso < 0) {
            throw new $exceptionClass('Los días de aviso no pueden ser negativos.');
        }
    }

    // Getters
    public function getId(): MovimientoPendienteId
    {
        return $this->id;
    }

    public function getCategoriaId(): CategoriaId
    {
        return $this->categoria_id;
    }

    public function getCuentaId(): CuentaId
    {
        return $this->cuenta_id;
    }

    public function getMovimientoFijoId(): ?MovimientoFijoId
    {
        return $this->movimiento_fijo_id;
    }

    public function getTipoMovimientoId(): int
    {
        return $this->tipo_movimiento_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function getFechaProgramada(): Date
    {
        return $this->fecha_programada;
    }

    public function getDiasAviso(): ?int
    {
        return $this->dias_aviso;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getEstado(): EstadosMovimientoPendiente
    {
        return $this->estado;
    }
}
