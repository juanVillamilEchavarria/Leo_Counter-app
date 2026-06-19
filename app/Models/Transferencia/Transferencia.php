<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */
namespace App\Models\Transferencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta\Cuenta;

class Transferencia extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'cuenta_enviadora_id',
        'cuenta_receptora_id',
        'monto',
        'descripcion',
        'fecha'
    ];

    public function cuentaEnviadora()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_enviadora_id');
    }

    public function cuentaReceptora()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_receptora_id');
    }
}
