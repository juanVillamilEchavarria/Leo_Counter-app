<?php

namespace App\Models\ArchivoMovimiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoMovimiento extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'movimiento_id',
        'nombre_original',
        'nombre_guardado',
        'path',
        'tamano_bytes',
        'notas',
        'disk',
        'extension',
        'mime_type',
    ];
}
