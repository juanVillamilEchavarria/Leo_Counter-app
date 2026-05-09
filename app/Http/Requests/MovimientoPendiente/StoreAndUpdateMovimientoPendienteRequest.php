<?php

namespace App\Http\Requests\MovimientoPendiente;

use Illuminate\Foundation\Http\FormRequest;

class StoreAndUpdateMovimientoPendienteRequest extends FormRequest
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
            'categoria_id'=> 'required|string|exists:categorias,id',
            'cuenta_id'=> 'required|string|exists:cuentas,id',
            'monto'=> 'required|numeric|min:0',
            'fecha_programada'=> 'required|date',
            'dias_aviso'=> 'nullable|numeric|min:0',
            'descripcion'=> 'nullable|string|max:1000',
            'url_pago'=> 'nullable|url|max:255',
        ];
    }
}
