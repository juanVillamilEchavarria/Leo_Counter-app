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
        return Storage::disk($dto->disk->value)->move($dto->oldPath, $dto->newPath);
    }


    public function destroy(FilePath $path, ArchivoMovimientoDiskEnum $disk): bool{
        return Storage::disk($disk->value)->delete($path->toString());
    }

    public function exists(string $path, ArchivoMovimientoDiskEnum $disk): bool{
        return Storage::disk($disk->value)->exists($path);
    }
}
