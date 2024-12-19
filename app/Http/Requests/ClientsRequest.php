<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que contiene las reglas de validación para la creación y actualización de un cliente.
 */
class ClientsRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'phone' => 'nullable|regex:/^\+?[1-9]\d{1,14}$/',
            'calle_numero' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'cp' => 'nullable|string|regex:/^\d{5}$/',
            'passport' => 'nullable|string|max:20',
            'country_id' => 'required|exists:countries,id',
        ];
    }
}
