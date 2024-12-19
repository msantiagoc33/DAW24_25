<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que contiene las reglas de validación para la creación y actualización de un apartamento.
 */
class ApartmentRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'address' => 'required|string|',
            'description' => 'string|nullable',
            'rooms' => 'integer|min:1|required',
            'capacidad' => 'integer|min:1|required'
        ];
    }
}
