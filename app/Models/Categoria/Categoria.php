<?php

namespace App\Models\Categoria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoMovimiento\TipoMovimiento;

class Categoria extends Model
{
    use HasFactory;

    protected $casts = [
        'es_fijo'=>'boolean'
    ];
    protected $fillable = [
        'nombre',
        'tipo_movimiento_id',
        'es_fijo',
        'descripcion'
    ];

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }
}
