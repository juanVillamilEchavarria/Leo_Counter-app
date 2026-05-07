<?php

namespace App\Models\Presupuesto;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Categoria\Categoria;
use App\Models\User;

class Presupuesto extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;      
    protected $keyType = 'string'; 

    protected $fillable = [
        'id',
        'categoria_id',
        'monto',
        'descripcion',
        'periodo',
        'user_id'
    ];
    protected $casts = [
        'periodo'=> 'date',
        'monto'=> 'decimal:2'
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
