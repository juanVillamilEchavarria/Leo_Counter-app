<?php
namespace App\Shared\Contracts\Actions;
use App\Shared\Abstracts\DTOs\DTO;
use Illuminate\Database\Eloquent\Model;
interface UpdateActionContract{
    public function update(Model $model, DTO $data): bool;
}