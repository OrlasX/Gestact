<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActasTable extends Migration
{
    public function up()
    {
        Schema::create('actas', function (Blueprint $table) {
            $table->id(); // ID autoincrementable de la tabla

            // Clave foránea user_id que referencia al usuario que crea el acta
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('nombre'); // Nombre del archivo PDF generado
            $table->string('apodo'); // Apodo o alias del acta, como un identificador adicional

            $table->string('identificacion'); // Identificación única del acta en formato específico (ej. "320-FCB-015")
            $table->date('fecha_reunion'); // Fecha en que se realizó la reunión
            $table->time('hora_inicial'); // Hora de inicio de la reunión
            $table->time('hora_final'); // Hora de finalización de la reunión
            $table->string('lugar_reunion'); // Lugar donde se llevó a cabo la reunión

            $table->string('proxima_reunion'); // Información de la próxima reunión (fecha y lugar)

            $table->boolean('editable')->default(true); // Campo booleano para indicar si el acta es editable

            $table->timestamps(); // Campos de marcas de tiempo automáticos (created_at y updated_at)
        });
    }

    public function down()
    {
        // Elimina la tabla actas en caso de realizar un rollback de la migración
        Schema::dropIfExists('actas');
    }
}

