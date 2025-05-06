<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{
    use HasFactory;

    // Si la tabla no sigue la convención de pluralización de Laravel, descomenta esto:
    // protected $table = 'actas';

    protected $fillable = [
        'nombre',
        'identificacion',
        'fecha_reunion',
        'hora_inicial',
        'hora_final',
        'lugar_reunion',
        'proxima_reunion',
        'user_id',
        'firmado',
        'apodo',
    ];

    // Definir la relación con los asistentes
    public function asistentes()
    {
        return $this->hasMany(Asistente::class, 'acta_id'); // 'acta_id' es la clave foránea en la tabla asistentes
    }

    // Definir la relación con los ausentes
    public function ausentes()
    {
        return $this->hasMany(Ausente::class);
    }

    // Definir la relación con los invitados
    public function invitados()
    {
        return $this->hasMany(Invitado::class);
    }

        // Definir la relación con los puntos del orden del día
        public function orden_del_dia()
        {
            return $this->hasMany(OrdenDia::class, 'acta_id'); // Asegúrate de que 'OrdenDelDia' es el nombre correcto del modelo
        }
    // Acta.php
public function user()
{
    return $this->belongsTo(User::class);
}


}
