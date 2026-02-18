<?php
namespace App\Shared\Actions\Files;

use Illuminate\Support\Facades\Storage;

class DestroyFileAction {
    public function destroy(string $path, string $disk = 'movimientos') : bool{
        return Storage::disk($disk)->delete($path);
    }
}