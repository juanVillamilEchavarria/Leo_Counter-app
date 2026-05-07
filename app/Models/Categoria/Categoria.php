<?php

namespace App\Models\Categoria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TipoMovimiento\TipoMovimiento;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'tipo_movimiento_id');
    }
}
