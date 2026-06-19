<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Requests\MovimientoEspontaneo;

use Illuminate\Foundation\Http\FormRequest;
class StoreMovimientoEspontaneoRequest extends FormRequest
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
            'cuenta_id'=> 'required|string|exists:cuentas,id',
            'categoria_id'=> 'required|string|exists:categorias,id',
            'monto'=> 'required|numeric|min:0.1',
            'descripcion'=> 'nullable|string|max:1000',
            'comprobantes'=> ['nullable', 'array'],
        ];
    }
}
