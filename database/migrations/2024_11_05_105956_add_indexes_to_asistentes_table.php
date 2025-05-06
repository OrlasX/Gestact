<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToAsistentesTable extends Migration
{
    public function up()
    {
        Schema::table('asistentes', function (Blueprint $table) {
            $table->index('nombre'); // Índice para nombre
        });
    }

    public function down()
    {
        Schema::table('asistentes', function (Blueprint $table) {
            $table->dropIndex(['nombre']); // Eliminar índice de nombre
        });
    }
}
