<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Clase que contiene las reglas de validación para la creación y actualización de un rol.
 */
class RoleRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para realizar esta solicitud.
     */
    public function authorize(): bool
    {
        return true; // Se cambia a true para permitir la validación al usuario
    }

    /**
     * Obtener las reglas de validación que se aplican a la solicitud.
     * 
     * La validación comprueba que se trate de una actualización o de una creación y en función de ello
     * se incluirá el id si es una actualización y en caso contrario no se incluirá, solo el nombre.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Verifica si es una actualización
        $isUpdating = $this->isMethod('put') || $this->isMethod('patch');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $isUpdating ? "unique:roles,name,' . $this->route('rol')->id" : 'unique:roles,name',
            ],
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permisos,id',
        ];
    }

    /**
     * Obtiene los mensajes de error personalizados para las reglas de validación.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser una cadena de texto.',
            'name.max' => 'El nombre del rol no puede superar los 255 caracteres.',
            'name.unique' => 'Ya existe un rol con ese nombre.',
        ];
    }
}
