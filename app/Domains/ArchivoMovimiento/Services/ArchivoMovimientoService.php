<?php

namespace App\Domains\ArchivoMovimiento\Services;

use App\Shared\Services\Files\FileService;
use App\Domains\ArchivoMovimiento\Repositories\Contracts\ArchivoMovimientoWriteRepositoryContract;
use App\Domains\ArchivoMovimiento\DTOs\StoreArchivoMovimientoDTO;
use App\Domains\ArchivoMovimiento\DTOs\UpdateArchivoMovimientoLocationDTO;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\DTOs\Files\MoveFileDTO;
use App\Shared\DTOs\Files\UploadFileDTO;
use App\Domains\ArchivoMovimiento\DTOs\ArchivoMovimientoTransferDTO;
use App\Domains\ArchivoMovimiento\Exceptions\CannotDeleteArchivoMovimientoException;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ArchivoMovimientoService  {

    private static string $disk = 'movimientos';
    public function __construct(
        private FileService $fileService,
        private ArchivoMovimientoWriteRepositoryContract $archivoMovimientoWriteRepository,
    )
    {
    }

    private function storeFile(int $movimiento_id, $file, FilePath $filePath): ArchivoMovimiento{
        $nombre_guardado = Str::uuid() . '.pdf';
         $dtoUpload = new UploadFileDTO(
            disk: self::$disk, 
            path: $filePath->toString(),
            name: $nombre_guardado,
            file: $file
        );
        $dto = new StoreArchivoMovimientoDTO(
            movimiento_id: $movimiento_id,
            nombre_guardado: $nombre_guardado,
            nombre_original: $file->getClientOriginalName(),
            path: $filePath->toString(),
            tamano_bytes: $file->getSize(),
        );

        $this->fileService->upload($dtoUpload);
        return $this->archivoMovimientoWriteRepository->store($dto);
    }
    public function store(ArchivoMovimientoTransferDTO $dto, FilePath $filePath) : void{
        foreach($dto->comprobantes as $file){
            $this->storeFile($dto->movimiento_id, $file, $filePath);
        }
       
    }

    public function moveFiles(array | Collection $files, FilePath $filePath):void{
        foreach($files as $file){
            $this->moveFile($file, $filePath);
        }

    }

    private function moveFile(ArchivoMovimiento $file, FilePath $filePath): void{
        $dtoUpdate = new UpdateArchivoMovimientoLocationDTO(
            path: $filePath->toString(),
        );
        $oldPath = FilePath::fromString($file->path);
        if($oldPath->equals($filePath)) return; // si la nueva ruta es igual a la antigua no se hace nada
        $dtoMove = MoveFileDTO::fromArchivoMovimientoAndNewPath($file, $filePath->toString());
        $this->archivoMovimientoWriteRepository->update($file, $dtoUpdate);
        $this->fileService->move($dtoMove);
    }
    public function delete(ArchivoMovimiento $archivoMovimiento): void{
        try {
              $archivoMovimiento->delete();
              if($this->fileService->exists($archivoMovimiento->path . $archivoMovimiento->nombre_guardado, $archivoMovimiento->disk)){
                   $this->fileService->destroy($archivoMovimiento->path . $archivoMovimiento->nombre_guardado, $archivoMovimiento->disk);
                 }
        } catch (\Throwable $th) {
            throw new CannotDeleteArchivoMovimientoException("No se pudo eliminar el archivo del movimiento. Error: " . $th->getMessage());
            
        }
    }

}