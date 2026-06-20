<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.1
 * @version 1.0.1
 */

namespace App\Models\Auditoria;

use Illuminate\Database\Eloquent\Model;
use App\Shared\Domain\ValueObjects\JsonPayload;
use App\Domains\Auditoria\Enums\AuditableTypes;
use App\Domains\Auditoria\Enums\AuditableActions;

/**
 * Modelo Eloquent que representa la tabla de auditorías.
 * Se encarga de exponer relaciones y castear enums y payloads JSON.
 *
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 */
class Auditoria extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'auditable_type',
        'auditable_id',
        'action',
        'old_values',
        'new_values'
    ];

    protected $casts = [
        'auditable_type' => AuditableTypes::class,
        'action' => AuditableActions::class,
    ];

    /**
     * Relación con el usuario que realizó la acción.
     */
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Accesor para obtener old_values decodificado como array o null.
     */
    public function getOldValuesAttribute($value)
    {
        if ($value === null) return null;
        if (is_array($value)) return $value;
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return null;
    }

    /**
     * Accesor para obtener new_values decodificado como array o null.
     */
    public function getNewValuesAttribute($value)
    {
        if ($value === null) return null;
        if (is_array($value)) return $value;
        if (is_string($value)) {
            return json_decode($value, true) ?: [];
        }
        return null;
    }

    /**
     * Mutator para asignar old_values a la forma que Eloquent persista (string JSON o null)
     */
    public function setOldValuesAttribute($value): void
    {
        if ($value instanceof JsonPayload) {
            $this->attributes['old_values'] = $value->getValue();
            return;
        }
        if (is_array($value)) {
            $this->attributes['old_values'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            return;
        }
        $this->attributes['old_values'] = $value;
    }

    /**
     * Mutator para asignar new_values a la forma que Eloquent persista (string JSON o null)
     */
    public function setNewValuesAttribute($value): void
    {
        if ($value instanceof JsonPayload) {
            $this->attributes['new_values'] = $value->getValue();
            return;
        }
        if (is_array($value)) {
            $this->attributes['new_values'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            return;
        }
        $this->attributes['new_values'] = $value;
    }
}
