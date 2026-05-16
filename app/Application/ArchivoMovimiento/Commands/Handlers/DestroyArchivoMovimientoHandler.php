<?php

namespace App\Application\ArchivoMovimiento\Commands\Handlers;

use App\Application\ArchivoMovimiento\Commands\DestroyArchivoMovimientoCommand;
use App\Domains\ArchivoMovimiento\Contracts\Repositories\ArchivoMovimientoRepositoryContract;
use App\Domains\ArchivoMovimiento\Exceptions\CannotDeleteArchivoMovimientoException;
use App\Shared\Application\Contracts\Services\FileServiceContract;
use App\Domains\ArchivoMovimiento\Aggregates\ArchivoMovimiento;
use App\Models\ArchivoMovimiento\ArchivoMovimiento as ArchivoMovimientoModel;
use Illuminate\Support\Facades\DB;
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
    ) : void
    {



        /** @var ArchivoMovimiento $archivoMovimiento */

       $archivoMovimiento = $this->archivoMovimientoRepository->findById($command->id);

     $name =  $archivoMovimiento->getPath()->toString() . $archivoMovimiento->getNombreGuardado();
        try {
            $this->archivoMovimientoRepository->destroy($command->id);
            if($this->fileService->exists($name,$archivoMovimiento->getDisk())){

                $this->fileService->destroy($name, $archivoMovimiento->getDisk());
            }
        } catch (\Throwable $th) {
            throw new CannotDeleteArchivoMovimientoException("No se pudo eliminar el archivo del movimiento. Error: " . $th->getMessage());

        }

    }
}
