<?php

namespace App\Models\Notificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuscriptorNotificacion extends Model
{
    use HasFactory;

    protected $table = 'suscriptores_notificaciones';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'activo' => 'boolean'
    ];

    protected $fillable = [
        'id',
        'user_id',
        'canal_notificacion_id',
        'activo'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function canal()
    {
        return $this->belongsTo(CanalNotificacion::class, 'canal_notificacion_id');
    }
}
