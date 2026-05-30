<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Shared\Domain\ValueObjects\Amount;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Categoria\Aggregates\Categoria;
use DateTimeImmutable;
use App\Shared\Application\Contracts\Bus\EventBus;
use App\Domains\Movimiento\Events\AttachmentsForMovimientoCreated;
use App\Domains\Movimiento\Events\MovimientoCreated;
/**
 * Manejador para el almacenamiento de un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreMovimientoHandler
{
    public function __construct(
        private CuentaRepositoryContract $cuentaRepository,
        private CategoriaRepositoryContract $categoriaRepository,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName,
        private IdGeneratorContract $idGenerator,
        private EventBus $eventBus,
        private MovimientoRepositoryContract $movimientoRepository
    )
    {
    }

    public function __invoke(StoreMovimientoCommand $command): void
    {
        $cuenta = $this->cuentaRepository->findById(new CuentaId($command->cuenta_id));
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $command->nombre,
            cuenta_id: $cuenta->getId(),
            categoria_id: new CategoriaId($command->categoria_id),
            tipo_movimiento_id: TipoMovimientoEnum::try($command->tipo_movimiento_id),
            monto: new Amount($command->monto),
            fecha: new Date(new DateTimeImmutable()),
            descripcion: $command->descripcion
        );
        $tipoMovimientoName = $this->tipoMovimientoName->getName(TipoMovimientoEnum::tryFrom($command->tipo_movimiento_id));
        /** @var Categoria $categoria */
        $categoria = $this->categoriaRepository->findById(new CategoriaId($command->categoria_id));
        $this->movimientoRepository->store($movimiento);
        $this->eventBus->publish(new MovimientoCreated($movimiento, $cuenta));
        $this->eventBus->publish(new AttachmentsForMovimientoCreated($movimiento, $categoria, $command->comprobantes, $tipoMovimientoName));

//


    }

}

