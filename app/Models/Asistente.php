<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cargo',
        'acta_id',
        'firmado',
    ];

    // Relación con el modelo Acta
    public function acta()
    {
        return $this->belongsTo(Acta::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id'); // Asegúrate de que el campo 'user_id' sea el correcto
    }

}
