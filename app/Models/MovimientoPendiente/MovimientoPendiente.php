<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Models\MovimientoPendiente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;
use App\Models\Categoria\Categoria;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Models\MovimientoFijo\MovimientoFijo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Movimiento\Movimiento;

class MovimientoPendiente extends Model
{
    use HasFactory, SoftDeletes;

      public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable =[
        'id',
        'nombre',
        'cuenta_id',
        'tipo_movimiento_id',
        'categoria_id',
        'movimiento_fijo_id',
        'fecha_programada',
        'estado',
        'dias_aviso',
        'monto',
        'descripcion',
        'paid_at'
    ];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipo_movimiento()
    {
        return $this->belongsTo(TipoMovimiento::class);
    }

    public function movimiento_fijo()
    {
        return $this->belongsTo(MovimientoFijo::class);
    }
    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }
}
