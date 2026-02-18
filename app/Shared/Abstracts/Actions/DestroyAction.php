<?php

namespace App\Shared\Abstracts\Actions;
use App\Shared\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use App\Shared\Contracts\Actions\DestroyActionContract;

abstract class DestroyAction extends Action implements DestroyActionContract{
    public function destroy(Model $model): bool
    {
        return $model->delete();
    }

    public function hardDelete(Model $model): bool
    {
        return $model->forceDelete();
    }
}