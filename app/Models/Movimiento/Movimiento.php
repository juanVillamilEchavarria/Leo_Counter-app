<?php

namespace App\Models\Movimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_id',
        'categoria_id',
        'tipo_movimiento_id',
        'monto',
        'fecha',
        'descripcion',
        'movimiento_pendiente_id'
    ];
}
