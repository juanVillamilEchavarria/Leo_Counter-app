<?php

namespace App\Application\Movimiento\Commands\Handlers;
use App\Application\Movimiento\Commands\StoreMovimientoCommand;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
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
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Shared\Domain\ValueObjects\Date;
use App\Domains\Categoria\Aggregates\Categoria;
use DateTimeImmutable;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Application\Movimiento\Resolvers\ApplyTransactionEffectForCuentaResolver;
use App\Application\Movimiento\Validators\MovimientoAttachmentValidator;
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
        private ApplyTransactionEffectForCuentaResolver $applyTransactionEffectForCuentaResolver,
        private CuentaRepositoryContract $cuentaRepository,
        private IdGeneratorContract $idGenerator,
        private MovimientoRepositoryContract $movimientoRepository,
        private CommandBus $commandBus,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName,
        private CategoriaRepositoryContract $categoriaRepository,
        private MovimientoAttachmentValidator $movimientoAttachmentValidator
    )
    {
    }

    public function __invoke(StoreMovimientoCommand $command): void
    {
        /** @var Cuenta $cuenta */
        $cuenta = $this->cuentaRepository->findById(new CuentaId($command->cuenta_id));
        $now = new Date(new DateTimeImmutable());
        $this->transactionValidatorResolver->resolve($cuenta, $command->monto, $command->tipo_movimiento_id);
        $this->movimientoAttachmentValidator->validateNumberOfFiles($command->comprobantes);
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
        /** @var Categoria $categoria */
        $categoria = $this->categoriaRepository->findById(new CategoriaId($command->categoria_id));
        $filePath = FilePathBuilder::buildFromNow(
            tipo_movimiento: $tipoMovimientoName,
            categoria: $categoria->getNombre(),
        );
        $this->movimientoRepository->store($movimiento);
        $cuenta = $this->applyTransactionEffectForCuentaResolver->resolve($movimiento, $cuenta);
        $this->cuentaRepository->update($cuenta);
        foreach($command->comprobantes as $comprobante){
            $archivoCommand= new StoreArchivoMovimientoCommand(
                movimiento_id: $movimiento->getId(),
                file: $comprobante,
                file_path: $filePath
            );
            $this->commandBus->dispatch($archivoCommand);


        }


    }

}
