<?php

namespace App\Shared\Actions\Files;

use App\Shared\Application\DTOs\Files\MoveFileDTO;
use Illuminate\Support\Facades\Storage;

class MoveFileAction
{
    public function move(MoveFileDTO $dto): bool
    {
        return Storage::disk($dto->disk)->move($dto->oldPath, $dto->newPath);
    }
}
