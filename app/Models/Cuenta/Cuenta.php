<?php

namespace App\Models\Cuenta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoCuenta\TipoCuenta;
use App\Models\Propietario\Propietario;
use App\Models\Movimiento\Movimiento;
class Cuenta extends Model
{
  use HasFactory;
  use SoftDeletes;
    public $incrementing = false;
    protected $keyType = 'string';

  protected $casts = [
    'active'=>'boolean'
  ];
  protected $fillable = [
      'id',
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
  public function movimientos(){
    return $this->hasMany(Movimiento::class);
  }
}
