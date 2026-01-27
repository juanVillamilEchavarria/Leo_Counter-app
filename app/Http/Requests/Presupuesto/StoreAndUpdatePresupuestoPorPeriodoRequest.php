<?php

namespace App\Http\Requests\Presupuesto;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdatePresupuestoPorPeriodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'categoria_id' => ['required', 'integer', 'exists:categorias,id'],
            'tipo_presupuesto_id' => ['required', 'integer', 'exists:tipo_presupuestos,id'],
            'monto' => ['required', 'numeric', 'min:0'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_final' => ['required', 'date', 'after:fecha_inicio'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }
}
