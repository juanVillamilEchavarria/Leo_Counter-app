<?php

namespace App\Shared\Contracts\Actions;
use Illuminate\Database\Eloquent\Model;

interface DestroyActionContract{
    public function delete(Model $model): bool;
    public function hardDelete(Model $model): bool;
}