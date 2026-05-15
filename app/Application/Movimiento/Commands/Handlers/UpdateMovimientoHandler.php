<?php

namespace App\Application\Movimiento\Commands\Handlers;

use App\Application\ArchivoMovimiento\Builders\FilePathBuilder;
use App\Application\ArchivoMovimiento\Commands\StoreArchivoMovimientoCommand;
use App\Application\Movimiento\Commands\UpdateMovimientoCommand;
use App\Application\Movimiento\Resolvers\TransactionValidatorResolver;
use App\Application\Movimiento\Resolvers\RevertTransactionEffectForCuentaResolver;
use App\Application\Movimiento\Resolvers\ApplyTransactionEffectForCuentaResolver;
use App\Application\Movimiento\Validators\MovimientoAttachmentValidator;
use App\Domains\ArchivoMovimiento\ValueObjects\ArchivoMovimientoId;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Domains\Cuenta\Contracts\Repositories\CuentaRepositoryContract;
use App\Domains\Movimiento\Aggregates\Movimiento;
use App\Domains\Cuenta\Aggregates\Cuenta;
use App\Domains\Categoria\Aggregates\Categoria;
use App\Domains\Movimiento\Exceptions\CannotExecuteMovimientoTransactionException;
use App\Domains\Movimiento\ValueObjects\MovimientoId;
use App\Domains\Cuenta\ValueObjects\CuentaId;
use App\Domains\Categoria\ValueObjects\CategoriaId;
use App\Domains\TipoMovimiento\Enums\TipoMovimientoEnum;
use App\Shared\Application\Contracts\Bus\CommandBus;
use App\Domains\Movimiento\Contracts\Repositories\MovimientoRepositoryContract;
use App\Domains\Categoria\Contracts\Repositories\CategoriaRepositoryContract;
use App\Shared\Application\Contracts\Queries\Executors\GetTipoMovimientoNameQueryExecutorContract;
use App\Application\ArchivoMovimiento\Commands\UpdateArchivoMovimientoCommand;
use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;

final readonly class UpdateMovimientoHandler
{
    public function __construct(
        private MovimientoRepositoryContract $movimientoRepository,
        private CuentaRepositoryContract $cuentaRepository,
        private CategoriaRepositoryContract $categoriaRepository,
        private GetTipoMovimientoNameQueryExecutorContract $tipoMovimientoName,
        private CommandBus $commandBus,
        private TransactionValidatorResolver $transactionValidatorResolver,
        private RevertTransactionEffectForCuentaResolver $revertTransactionEffectForCuentaResolver,
        private ApplyTransactionEffectForCuentaResolver $applyTransactionEffectForCuentaResolver,
        private MovimientoAttachmentValidator $movimientoAttachmentValidator
    )
    {
    }
    public function __invoke(UpdateMovimientoCommand $command): void
    {
        /** @var Movimiento $movimiento */
        $movimiento = $this->movimientoRepository->findById(new MovimientoId($command->id));
        /** @var Cuenta $cuenta */
        $cuenta = $this->cuentaRepository->findById(new CuentaId($command->cuenta_id));
        // se envia al resolver de reversion de transaccion que devuelve la cuenta ya revertida (la cuenta del comando, la nueva enviada )
        $cuenta = $this->revertTransactionEffectForCuentaResolver->resolve($command, $movimiento, $cuenta);
        try {
            $this->transactionValidatorResolver->resolve($cuenta, $command->monto, $command->tipo_movimiento_id);
        } catch (\Exception $e) {
            throw new CannotExecuteMovimientoTransactionException ('No se pudo realizar la transacción'. $e->getMessage());

        }
        // se envia al resolver de aplicacion de transaccion que devuelve la cuenta ya aplicada (la cuenta del comando, la nueva enviada )
        $cuenta = $this->applyTransactionEffectForCuentaResolver->resolve($movimiento, $cuenta);

       $this->movimientoAttachmentValidator->validateNumberOfFiles(array_merge($command->comprobantes, $command->comprobantes_existing));
        $tipoMovimientoName = $this->tipoMovimientoName->getName(TipoMovimientoEnum::tryFrom($command->tipo_movimiento_id));
       /** @var Categoria $categoria */
       $categoria = $this->categoriaRepository->findById(new CategoriaId($command->categoria_id));
       $movimiento = $movimiento->updateData(
           nombre: $command->nombre,
           cuenta_id: $cuenta->getId(),
           categoria_id: $categoria->getId(),
           tipo_movimiento_id: $command->tipo_movimiento_id,
           monto: $command->monto,
           fecha: $movimiento->getFecha(),
           descripcion: $command->descripcion,

       );
       $this->movimientoRepository->update($movimiento);
       $this->cuentaRepository->update($cuenta);
        $filePath = FilePathBuilder::buildFromNow(
            $tipoMovimientoName,
            $categoria->getNombre()
        );
       $this->storeNewAttachments($command->comprobantes, $movimiento->getId(), $filePath);
       $this->updateAttachments($command->comprobantes, $filePath);
       $this->deleteAttachments($command->comprobantes_delete_ids);


    }

    /**
     * Almacena los archivos de comprobante
     * @param array $comprobantes
     * @param MovimientoId $movimientoId
     * @param FilePath $filePath
     * @return void
     */
    private function storeNewAttachments(array $comprobantes, MovimientoId $movimientoId, FilePath $filePath){
        foreach($comprobantes as $comprobante){
            $this->commandBus->dispatch(new StoreArchivoMovimientoCommand(
                movimiento_id: $movimientoId,
                file: $comprobante,
                file_path: $filePath
            ));
        }

    }

    /**
     * Actualiza los archivos de comprobante
     * @param array|null $comprobantes
     * @param FilePath $filePath
     * @return void
     */
    private function updateAttachments( ?array $comprobantes, FilePath $filePath){
        if(!is_array($comprobantes)) return;
            foreach($comprobantes as $comp_exist){
                $id = new ArchivoMovimientoId($comp_exist);
                $this->commandBus->dispatch(new UpdateArchivoMovimientoCommand(
                    id: $id,
                    filePath: $filePath
                ));
            }
    }

    /**
     * Elimina los archivos de comprobante
     * @param array|null $comprobantes
     * @return void
     */
    private function deleteAttachments(?array $comprobantes){
        if(!is_array($comprobantes)) return;
            foreach ($comprobantes as $comp_delete_id){
                $id = new ArchivoMovimientoId($comp_delete_id);
                $this->commandBus->dispatch(new DestroyArchivoMovimientoCommand(
                    id: $id
                ));
            }
    }

}
