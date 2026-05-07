<?php

namespace App\Models\Propietario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;

class Propietario extends Model
{
    use HasFactory;
      public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'telefono'
    ];

    public function cuentas (){
        return $this->hasMany(Cuenta::class);
    }
}
