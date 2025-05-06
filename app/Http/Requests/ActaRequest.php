<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActaRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cambia esto si necesitas autorización.
    }

    public function rules()
    {
        return [

            'nombre' => 'required|string|max:255',
            'identificacion' => 'required|string|max:255',
            'fecha_reunion' => 'required|date',
            'hora_inicial' => 'required|date_format:H:i',
            'hora_final' => 'required|date_format:H:i|after:hora_inicial',
            'lugar_reunion' => 'required|string|max:255',
            'asistentes' => 'required|array',
            'asistentes.*' => 'string|max:255',
            'cargos_asistentes' => 'required|array',
            'cargos_asistentes.*' => 'string|max:255',
            'ausentes' => 'nullable|array', // Ahora es nullable
            'ausentes.*' => 'nullable|string|max:255', // Permite que cada elemento sea nullable
            'cargos_ausentes' => 'nullable|array', // Ahora es nullable
            'cargos_ausentes.*' => 'nullable|string|max:255', // Permite que cada elemento sea nullable
            'invitados' => 'nullable|array', // Ahora es nullable
            'invitados.*' => 'nullable|string|max:255', // Permite que cada elemento sea nullable
            'cargos_invitados' => 'nullable|array', // Ahora es nullable
            'cargos_invitados.*' => 'nullable|string|max:255', // Permite que cada elemento sea nullable
            'orden_del_dia' => 'required|array',
            'orden_del_dia.*' => 'string|max:255',
            'descripcion_orden' => 'required|array',
            'descripcion_orden.*' => 'string|max:1000',
            'proxima_reunion' => 'required|string|max:255',

        ];
    }
}
