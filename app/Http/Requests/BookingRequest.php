<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que contiene las reglas de validación para la creación y actualización de una reserva.
 */
class BookingRequest extends FormRequest
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
            'fechaEntrada' => 'required|date', 
            'fechaSalida' => 'required|date',
            'huespedes' => 'required|integer|min:1',
            'importe' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'comentario' => 'nullable|string|max:500',
            'platform_id' => 'required|exists:platforms,id', // Aseguramos que la plataforma existe en la columna id de la tabla platforms
            'client_id' => 'required|exists:clients,id', // Aseguramos que el cliente existe en la columna id de la tabla clients
            'apartment_id' => 'required|exists:apartments,id', // Aseguramos que el apartamento existe en la columna id de la tabla apartments
        ];
    }
}
