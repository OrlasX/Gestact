<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cargo',
        'acta_id',
    ];

    // Relación con el modelo Acta
    public function acta()
    {
        return $this->belongsTo(Acta::class);
    }
}
