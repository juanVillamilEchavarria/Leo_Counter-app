<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
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
        'active' => 'boolean'
    ];

    protected $fillable = [
        'id',
        'user_id',
        'canal_notificacion_id',
        'active',
        'verified_at'
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
