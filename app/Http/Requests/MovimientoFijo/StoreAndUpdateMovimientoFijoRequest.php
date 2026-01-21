<?php

namespace App\Http\Requests\MovimientoFijo;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdateMovimientoFijoRequest extends FormRequest
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
            'nombre'=> 'required|string|max:255',
            'tipo_movimiento_id'=> 'required|integer|exists:tipo_movimientos,id',
            'categoria_id'=> 'required|integer|exists:categorias,id',
            'cuenta_id'=> 'required|integer|exists:cuentas,id',
            'monto'=> 'required|numeric|min:0',
            'fecha_proximo'=> 'required|date',
            'frecuencia_movimiento_id'=> 'required|numeric|exists:frecuencia_movimientos,id',
            'descripcion'=> 'nullable|string|max:1000',
            'url_pago'=> 'nullable|url|max:255',
        ];
    }
}
