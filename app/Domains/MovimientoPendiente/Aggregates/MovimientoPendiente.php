<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Domains\MovimientoPendiente\Aggregates;

use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\MovimientoFijo\ValueObjects\MovimientoFijoId;
use App\Domains\MovimientoPendiente\Enums\EstadosMovimientoPendiente;
use App\Domains\MovimientoPendiente\Exceptions\CannotStoreMovimientoPendienteException;
use App\Domains\MovimientoPendiente\Exceptions\CannotUpdateMovimientoPendienteException;
use App\Domains\MovimientoPendiente\ValueObjects\MovimientoPendienteId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Domain\Contracts\AggregateModelContract;
use App\Shared\Domain\ValueObjects\Amount;
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
        private TipoMovimientoEnum         $tipo_movimiento_id,
        private string                     $nombre,
        private Amount                     $monto,
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
     * @param TipoMovimientoEnum $tipo_movimiento_id Identificador del tipo de movimiento.
     * @param string $nombre Nombre descriptivo.
     * @param Amount $monto Monto del movimiento.
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
        TipoMovimientoEnum          $tipo_movimiento_id,
        string                      $nombre,
        Amount                      $monto,
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
        TipoMovimientoEnum         $tipo_movimiento_id,
        string                     $nombre,
        Amount                     $monto,
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
        CategoriaId        $categoria_id,
        CuentaId           $cuenta_id,
        TipoMovimientoEnum $tipo_movimiento_id,
        string             $nombre,
        Amount             $monto,
        Date               $fecha_programada,
        ?int               $dias_aviso,
        ?string            $descripcion,
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

    public function isWarningDay():bool{
        if ($this->dias_aviso === null || $this->dias_aviso <= 0) {
            return false;
        }
        $fecha_proimo = $this->fecha_programada->getPeriod();
        $today = new \DateTimeImmutable();
        $fecha_aviso = $fecha_proimo->sub(new \DateInterval('P' . $this->dias_aviso . 'D'));
        return $today->format('Y-m-d') === $fecha_aviso->format('Y-m-d');
    }

    /**
     * Verifica si el movimiento pendiente vencio ayer.
     * @return bool
     * @throws \DateInvalidOperationException
     */
    public function wasExpiredYesterday(): bool{
        $yesterday = (new \DateTimeImmutable())->sub(new \DateInterval('P1D'));
        return $yesterday->format('Y-m-d') === $this->fecha_programada->getPeriod()->format('Y-m-d');
    }

    private static function validateData(
        string             $nombre,
        Amount             $monto,
        TipoMovimientoEnum $tipo_movimiento_id,
        ?int               $dias_aviso,
        string             $exceptionClass,
    ): void
    {
        if (trim($nombre) === '') {
            throw new $exceptionClass('El nombre del movimiento pendiente es obligatorio.');
        }

        if ($monto->getValue() < 0) {
            throw new $exceptionClass('El monto del movimiento pendiente no puede ser negativo.');
        }

        if ($tipo_movimiento_id->value <= 0) {
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

    public function getTipoMovimientoId(): TipoMovimientoEnum
    {
        return $this->tipo_movimiento_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getMonto(): Amount
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
