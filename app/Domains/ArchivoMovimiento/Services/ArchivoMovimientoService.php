<?php

namespace App\Domains\ArchivoMovimiento\Services;

use App\Domains\ArchivoMovimiento\Actions\StoreArchivoMovimientoAction;
use App\Domains\ArchivoMovimiento\Actions\UpdateArchivoMovimientoAction;
use App\Domains\ArchivoMovimiento\DTOs\StoreArchivoMovimientoDTO;
use App\Domains\ArchivoMovimiento\DTOs\UpdateArchivoMovimientoLocationDTO;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
use App\Shared\Actions\Files\UploadFileAction;
use App\Shared\DTOs\UploadFileDTO;
use App\Domains\ArchivoMovimiento\DTOs\ThrowArchivoMovimientoDTO;
use App\Domains\ArchivoMovimiento\Exceptions\CannotDeleteArchivoMovimientoException;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
class ArchivoMovimientoService  {
    public function __construct(
        private StoreArchivoMovimientoAction $storeArchivoMovimientoAction,
        private UpdateArchivoMovimientoAction $updateArchivoMovimientoAction,
        private UploadFileAction $uploadFileAction
    )
    {
    }

    private function makePath(int $year, int $month, string $tipo_movimiento, string $categoria): string{
        return "{$year}/{$month}/{$tipo_movimiento}/{$categoria}/";
    }

    public function store(ThrowArchivoMovimientoDTO $dto) : void{
        $categoria = Str::slug($dto->categoria);
        $movimiento_id = $dto->movimiento_id;
        $tipo_movimiento = $dto->tipo_movimiento;
        
        foreach($dto->comprobantes as $file){
                    $nombre_guardado = Str::uuid() . '.pdf';
                $year = Carbon::now()->year;
                $month = Carbon::now()->month;
                $path = $this->makePath($year, $month, $tipo_movimiento, $categoria);
                $dto = new StoreArchivoMovimientoDTO(
                    movimiento_id: $movimiento_id,
                    nombre_guardado: $nombre_guardado,
                    nombre_original: $file->getClientOriginalName(),
                    path: $path,
                    tamano_bytes: $file->getSize(),
                );
                $dtoUpload = new UploadFileDTO(
                    disk: $dto->disk,
                    path: $path,
                    name: $nombre_guardado,
                    file: $file
                );
                $this->uploadFileAction->upload($dtoUpload);
                $this->storeArchivoMovimientoAction->store($dto);
        }
       
    }

    public function updateLocation(ThrowArchivoMovimientoDTO $dto): void{
        $categoria = Str::slug($dto->categoria);
        /** @var ArchivoMovimiento $file */
        foreach($dto->comprobantes as $file){
           $yearPath = Str::of($file->path)->explode('/')->take(2)->implode('/');
           $year = (int) explode('/', $yearPath)[0];
           $month = (int) explode('/', $yearPath)[1];
           $newPath = $this->makePath($year, $month, $dto->tipo_movimiento, $categoria);
               
           $dtoUpdate = new UpdateArchivoMovimientoLocationDTO(
            path: $newPath
           );
           dd($dtoUpdate);
            $this->updateArchivoMovimientoAction->update($file, $dto);
        }
    }

    public function delete(ArchivoMovimiento $archivoMovimiento): void{
        try {
              $archivoMovimiento->delete();
              if(Storage::disk($archivoMovimiento->disk)->exists($archivoMovimiento->path . $archivoMovimiento->nombre_guardado)){
                    Storage::disk($archivoMovimiento->disk)->delete($archivoMovimiento->path . $archivoMovimiento->nombre_guardado);
                 }
        } catch (\Throwable $th) {
            throw new CannotDeleteArchivoMovimientoException("No se pudo eliminar el archivo del movimiento. Error: " . $th->getMessage());
            
        }
    }

}