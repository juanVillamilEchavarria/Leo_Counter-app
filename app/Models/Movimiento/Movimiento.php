<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Models\Movimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;
use App\Models\Categoria\Categoria;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Models\ArchivoMovimiento\ArchivoMovimiento;
class Movimiento extends Model
{
    use HasFactory;
      public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nombre',
        'cuenta_id',
        'categoria_id',
        'tipo_movimiento_id',
        'monto',
        'fecha',
        'descripcion',
        'movimiento_pendiente_id'
    ];

    public function cuenta(){
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
    public function movimientoPendiente(){
        return $this->belongsTo(MovimientoPendiente::class);
    }

    public function tipo_movimiento(){
        return $this->belongsTo(TipoMovimiento::class);
    }

    public function archivoMovimientos(){
        return $this->hasMany(ArchivoMovimiento::class);
    }
}
