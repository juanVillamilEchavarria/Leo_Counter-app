<?php

namespace App\Models\MovimientoPendiente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;
use App\Models\Categoria\Categoria;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Models\MovimientoFijo\MovimientoFijo;

class MovimientoPendiente extends Model
{
    use HasFactory;

    protected $fillable =[
        'nombre',
        'cuenta_id',
        'tipo_movimiento_id',
        'categoria_id',
        'movimiento_fijo_id',
        'fecha_programada',
        'estado',
        'dias_aviso',
        'url_pago',
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
