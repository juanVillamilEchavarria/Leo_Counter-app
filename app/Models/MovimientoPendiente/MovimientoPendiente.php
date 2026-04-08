<?php

namespace App\Models\MovimientoPendiente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;
use App\Models\Categoria\Categoria;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Models\MovimientoFijo\MovimientoFijo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimientoPendiente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =[
        'nombre',
        'cuenta_id',
        'tipo_movimiento_id',
        'categoria_id',
        'movimiento_fijo_id',
        'fecha_programada',
        'estado',
        'dias_aviso',
        'monto',
        'descripcion'
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
}
