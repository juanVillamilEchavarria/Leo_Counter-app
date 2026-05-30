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

class CanalNotificacion extends Model
{
    use HasFactory;

    protected $table = 'canales_notificacion';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'active' => 'boolean'
    ];

    protected $fillable = [
        'id',
        'nombre',
        'active'
    ];

    public function suscriptores()
    {
        return $this->hasMany(SuscriptorNotificacion::class, 'canal_notificacion_id');
    }
}
