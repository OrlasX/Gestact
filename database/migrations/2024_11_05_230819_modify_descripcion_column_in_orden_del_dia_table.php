<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDescripcionColumnInOrdenDelDiaTable extends Migration
{
    public function up()
    {
        Schema::table('orden_del_dia', function (Blueprint $table) {
            $table->text('descripcion')->change(); // Cambiar a tipo TEXT
        });
    }

    public function down()
    {
        Schema::table('orden_del_dia', function (Blueprint $table) {
            $table->string('descripcion', 255)->change(); // Cambia esto al tipo original, si era VARCHAR
        });
    }

};
