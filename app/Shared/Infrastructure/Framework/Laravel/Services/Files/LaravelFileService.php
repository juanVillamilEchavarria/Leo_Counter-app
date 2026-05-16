<?php
namespace App\Shared\Infrastructure\Framework\Laravel\Services\Files;

use App\Domains\ArchivoMovimiento\Enums\ArchivoMovimientoDiskEnum;
use App\Domains\ArchivoMovimiento\ValueObjects\FilePath;
use App\Shared\Application\Contracts\Services\FileServiceContract;
use App\Shared\Application\DTOs\Files\MoveFileDTO;
use App\Shared\Application\DTOs\Files\UploadFileDTO;
use App\Shared\Exceptions\CannotUploadFileException;
use Illuminate\Support\Facades\Storage;

/**
 * Implementacion de FileService para Laravel
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @since 1.0.0
 * @version 1.0.0
 */
class LaravelFileService implements FileServiceContract{
    public function upload(UploadFileDTO $dto) : bool{
        return Storage::disk($dto->disk->value)->putFileAs($dto->path, $dto->file->path(), $dto->name, $dto->options) ? true : throw new CannotUploadFileException();
    }

    public function move(MoveFileDTO $dto): bool{

        $disk = Storage::disk($dto->disk->value);

        if (!$disk->exists($dto->oldPath)) {
            return false;
        }

        // Intentar mover primero
        $moved = $disk->move($dto->oldPath, $dto->newPath);

        // Si falla, copiar y eliminar manualmente
        if (!$moved) {
            $copied = $disk->copy($dto->oldPath, $dto->newPath);
            if ($copied) {
                $disk->delete($dto->oldPath);
                return true;
            }
            return false;
        }

        return $moved;
    }


    public function destroy(string $path, ArchivoMovimientoDiskEnum $disk): bool{
        return Storage::disk($disk->value)->delete($path);
    }

    public function exists(string $path, ArchivoMovimientoDiskEnum $disk): bool{
        return Storage::disk($disk->value)->exists($path);
    }
}
