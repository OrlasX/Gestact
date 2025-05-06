<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDia extends Model
{
    use HasFactory;

    protected $table = 'orden_del_dia'; // Asegú

    protected $fillable = [
        'nombre',
        'descripcion',
        'acta_id',
    ];

    // Relación con el modelo Acta
    public function acta()
    {
        return $this->belongsTo(Acta::class, 'acta_id'); // 'acta_id' debe coincidir con la clave foránea
    }
}
