<?php

namespace App\Application\ArchivoMovimiento\Commands\Handlers;

use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Domains\ArchivoMovimiento\Exceptions\CannotDeleteArchivoMovimientoException;
use App\Shared\Application\Contracts\Services\FileServiceContract;
use App\Domains\ArchivoMovimiento\Aggregates\ArchivoMovimiento;
use App\Models\ArchivoMovimiento\ArchivoMovimiento as ArchivoMovimientoModel;
final readonly class DestroyArchivoMovimientoHandler
{

    public function __construct(
        private ArchivoMovimientoRepositoryContract $archivoMovimientoRepository,
        private FileServiceContract $fileService
    )
    {
    }
    public function __invoke(
        DestroyArchivoMovimientoCommand $command
    )
    {

        /** @var ArchivoMovimiento $archivoMovimiento */
       $archivoMovimiento = $this->archivoMovimientoRepository->findById($command->id);
       dd($archivoMovimiento, $command->id, ArchivoMovimientoModel::query()->where('id', $command->id->getValue())->toSql(), ArchivoMovimientoModel::query()->where('id', $command->id->getValue())->getBindings());
        try {
            $this->archivoMovimientoRepository->destroy($command->id);
            if($this->fileService->exists($archivoMovimiento->getPath(),$archivoMovimiento->getDisk())){
                $this->fileService->destroy($archivoMovimiento->getPath(), $archivoMovimiento->getDisk());
            }
        } catch (\Throwable $th) {
            throw new CannotDeleteArchivoMovimientoException("No se pudo eliminar el archivo del movimiento. Error: " . $th->getMessage());

        }

    }
}
