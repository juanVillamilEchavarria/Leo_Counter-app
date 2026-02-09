<?php

namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class GetCuentaAction
{

    private array $relations = ['propietario', 'tipo_cuenta'];

    public function getAllAvalaibleWithDetails(): Collection {
        return $this->baseQueryWithDetails()->get();
    }

    private function baseQueryWithDetails(){
        return Cuenta::query()->with($this->relations);
    }

    public function getAll(): Collection {
        return Cuenta::all();
    }

    public function getRecordsCount(): int{
        return Cuenta::count();
    }

    public function where(string $attribute, $value): Builder{
        
        return Cuenta::query()->where($attribute, $value);
    }
}