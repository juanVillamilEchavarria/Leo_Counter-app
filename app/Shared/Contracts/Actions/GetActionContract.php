<?php

namespace App\Shared\Contracts\Actions;

use Illuminate\Database\Eloquent\Model;
interface GetActionContract{
    public function getAllWithDetails();
    public function getWithDetails(Model $model);
    public function getRecordsCount();
}