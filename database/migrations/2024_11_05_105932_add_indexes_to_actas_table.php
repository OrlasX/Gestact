<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToActasTable extends Migration
{
    public function up()
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->index('lugar_reunion'); // Índice para lugar_reunion
            $table->index('apodo'); // Índice para apodo
        });
    }

    public function down()
    {
        Schema::table('actas', function (Blueprint $table) {
            $table->dropIndex(['lugar_reunion']); // Eliminar índice de lugar_reunion
            $table->dropIndex(['apodo']); // Eliminar índice de apodo
        });
    }
}
