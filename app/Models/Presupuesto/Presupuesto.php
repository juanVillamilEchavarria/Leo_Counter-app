<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Categoria\Categoria;
use App\Models\User;
use App\Models\TipoPresupuesto\TipoPresupuesto;

class Presupuesto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'categoria_id',
        'tipo_presupuesto_id',
        'monto',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'user_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
        'monto' => 'decimal:2'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function tipoPresupuesto()
    {
        return $this->belongsTo(TipoPresupuesto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
