<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que contiene las reglas de validación para la creación y actualización de una factura.
 */
class FacturasRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fecha' => 'required|date|before_or_equal:today',
            'importe' => 'required|numeric',
            'notas' => 'nullable|string|max:250',
            'file_uri' => 'nullable|file|mimes:pdf,jpeg,png,jpg,docx,odt',
            'apartment_id' => 'required|exists:apartments,id',
            'conceptos' => 'required|array',
        ];
    }
}
