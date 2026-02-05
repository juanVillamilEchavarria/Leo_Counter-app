<?php

namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class GetCuentaAction
{

    public function getAllAvalaibleWithDetails(): Collection {
        return $this->allAvailable()->with(['propietario', 'tipo_cuenta'])->get();
    }

    public function allAvailable(): Builder{
        return Cuenta::query()->where('archived', false);
    }

    public function getRecordsCount(): int{
        return $this->allAvailable()->count();
    }

    public function where(string $attribute, $value): ?Cuenta{
        return Cuenta::where($attribute, $value)->first();
    }
}