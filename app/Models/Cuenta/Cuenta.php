<?php

namespace App\Models\Cuenta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCuenta\TipoCuenta;
use App\Models\Propietario\Propietario;

class Cuenta extends Model
{
  use HasFactory;
  protected $fillable = [
    'nombre',
    'saldo_inicial',
    'saldo_actual',
    'tipo_cuenta_id',
    'propietario_id',
    'notas',
    'active',
    'archived'

  ];
  public function propietario(){
    return $this->belongsTo(Propietario::class);
  }
  public function tipo_cuenta(){
    return $this->belongsTo(TipoCuenta::class);
  }
}
