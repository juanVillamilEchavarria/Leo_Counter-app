<?php
namespace App\Shared\Services\Files;

use App\Shared\Actions\Files\DestroyFileAction;
use App\Shared\Actions\Files\UploadFileAction;
use App\Shared\Actions\Files\MoveFileAction;
use App\Shared\DTOs\Files\MoveFileDTO;
use App\Shared\DTOs\Files\UploadFileDTO;
use Illuminate\Support\Facades\Storage;

class FileService{
    public function __construct(
        private UploadFileAction $uploadFileAction,
        private MoveFileAction $moveFileAction,
        private DestroyFileAction $destroyFileAction
    )
    {
    }
    public function upload(UploadFileDTO $dto) : bool{
        return $this->uploadFileAction->upload($dto);
    }

    public function move(MoveFileDTO $dto): bool{
        return $this->moveFileAction->move($dto);
    }
 

    public function destroy(string $path, string $disk): bool{
        return $this->destroyFileAction->destroy($path, $disk);
    }

    public function exists(string $path, string $disk): bool{
        return Storage::disk($disk)->exists($path);
    }
}