<?php

namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Shared\Domain\Contracts\IdGeneratorContract;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Application\ArchivoMovimiento\Commands\Handlers\StoreArchivoMovimientoHandler;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use DateTimeImmutable;

/**
 * Manejador para el almacenamiento de un movimiento.
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
final readonly class StoreMovimientoHandler
{
    public function __construct(
        private TransactionValidatorResolver $transactionValidatorResolver,
        private CuentaRepositoryContract $cuentaRepository,
        private IdGeneratorContract $idGenerator,
        private MovimientoRepositoryContract $movimientoRepository,
        private StoreArchivoMovimientoHandler $storeArchivoMovimientoHandler,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName,
        private CategoriaRepositoryContract $categoriaRepository
    )
    {
    }

    public function __invoke(StoreMovimientoCommand $command): void
    {
        dd('llego');
        /** @var Cuenta $cuenta */
        $cuenta = $this->cuentaRepository->findById(new CuentaId($command->cuenta_id));
        $now = new DateTimeImmutable();
        $this->transactionValidatorResolver->resolve($cuenta, $command->monto, $command->tipo_movimiento_id);
        $movimiento = Movimiento::create(
            id: MovimientoId::generate($this->idGenerator),
            nombre: $command->nombre,
            cuenta_id: $cuenta->getId(),
            categoria_id: new CategoriaId($command->categoria_id),
            tipo_movimiento_id: $command->tipo_movimiento_id,
            monto: $command->monto,
            fecha: $now,
            descripcion: $command->descripcion
        );
        $tipoMovimientoName = $this->tipoMovimientoName->getName(TipoMovimientoEnum::tryFrom($command->tipo_movimiento_id));
        $categoria = $this->categoriaRepository->findById(new CategoriaId($command->categoria_id));
        $filePath = new FilePath(
            year: $now->format('Y'),
            month: $now->format('m'),
            tipo_movimiento: $tipoMovimientoName,
            categoria: $categoria,
        );
        foreach($command->comprobantes as $comprobante){
            $archivoCommand= new StoreArchivoMovimientoCommand(
                movimiento_id: $movimiento->getId(),
                file: $comprobante,
                file_path: $filePath
            );
            $this->storeArchivoMovimientoHandler->__invoke($archivoCommand);

        }
        $this->movimientoRepository->store($movimiento);

    }

}
