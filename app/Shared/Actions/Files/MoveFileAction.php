<?php

namespace App\Shared\Actions\Files;

use Illuminate\Support\Facades\Storage;
use App\Shared\DTOs\Files\MoveFileDTO;

class MoveFileAction
{
    public function move(MoveFileDTO $dto): bool
    {
        return Storage::disk($dto->disk)->move($dto->oldPath, $dto->newPath);
    }
}