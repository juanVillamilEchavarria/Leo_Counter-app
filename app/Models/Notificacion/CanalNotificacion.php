<?php

namespace App\Models\Notificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanalNotificacion extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'activo' => 'boolean',
        'configuracion' => 'array'
    ];

    protected $fillable = [
        'id',
        'nombre',
        'activo',
        'configuracion'
    ];

    public function suscriptores()
    {
        return $this->hasMany(SuscriptorNotificacion::class, 'canal_notificacion_id');
    }
}
