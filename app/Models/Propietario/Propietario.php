<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
        'id',
        'nombre',
        'apellido',
        'email',
        'telefono'
    ];

    public function cuentas (){
        return $this->hasMany(Cuenta::class);
    }
}
