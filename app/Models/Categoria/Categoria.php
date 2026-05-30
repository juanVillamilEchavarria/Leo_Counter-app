<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Models\Categoria;

use App\Models\MovimientoFijo\MovimientoFijo;
use App\Models\MovimientoPendiente\MovimientoPendiente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoMovimiento\TipoMovimiento;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Movimiento\Movimiento;

class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'es_fijo'=>'boolean'
    ];
    protected $fillable = [
        'id',
        'nombre',
        'tipo_movimiento_id',
        'es_fijo',
        'descripcion'
    ];

    public function tipo_movimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }
    public function movimientos(){
        return $this->hasMany(Movimiento::class, 'categoria_id');
    }
    public function movimientos_fijos(){
        return $this->hasMany(MovimientoFijo::class, 'categoria_id');
    }

    public function movimientos_pendientes(){
        return $this->hasMany(MovimientoPendiente::class, 'categoria_id');
    }
}
