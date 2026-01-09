<?php

namespace App\Domains\Cuenta\Actions;

use App\Models\Cuenta\Cuenta;
use Illuminate\Database\Eloquent\Collection;
use App\Domains\Cuenta\Resources\CuentaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Database\Eloquent\Builder;

class GetCuentaAction
{

    public function getAllAvalaibleWhitDetails(): AnonymousResourceCollection{
        $cuentas = $this->allAvailable()->with(['propietario', 'tipo_cuenta'])->get();
        return CuentaResource::collection($cuentas);
    }
  public function allAvailable(): Builder{
    return Cuenta::query()->where('archived', false);
  }
   public function where(string $attribute, $value): ?Cuenta{
       return Cuenta::where($attribute, $value)->first();
   }
}