<?php

namespace App\Models\MovimientoFijo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;
use App\Models\Categoria\Categoria;
use App\Models\TipoMovimiento\TipoMovimiento;
use App\Models\FrecuenciaMovimiento\FrecuenciaMovimiento;
use App\Models\MovimientoPendiente\MovimientoPendiente;

class MovimientoFijo extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'active'=>'boolean',
        'registrar_automatico' =>'boolean'
    ];

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'tipo_movimiento_id',
        'categoria_id',
        'cuenta_id',
        'frecuencia_movimiento_id',
        'fecha_proximo',
        'monto',
        'dias_aviso',
        'active',
        'registrar_automatico'


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

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }

    public function frecuencia_movimiento()
    {
        return $this->belongsTo(FrecuenciaMovimiento::class);
    }

    public function frecuencia()
    {
        return $this->belongsTo(FrecuenciaMovimiento::class, 'frecuencia_movimiento_id');
    }

    public function movimientos_pendientes()
    {
        return $this->hasMany(MovimientoPendiente::class);
    }
}
