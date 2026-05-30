<?php

/*
 * @package Leo Counter
 * @author Juan Villamil <juanestebanvillamilechavarria@gmail.com>
 * @license MIT
 * @copyright 2026 Juan Esteban Villamil Echavarria
 * @since 1.0.0
 * @version 1.0.0
 */
namespace App\Http\Requests\Reporte;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReporteRequest extends FormRequest
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
            'startDate' => ['required', 'date'],
            'endDate' => ['required', 'date'],
            'categorias' => ['nullable', 'array'],
            'cuentas' => ['nullable', 'array'],
            'only_categorias_fijas' => ['required', 'boolean'],
        ];
    }
}
