<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID autoincrementable del usuario

            $table->string('name'); // Nombre completo del usuario

            $table->string('email'); // Correo electrónico único para el usuario
            $table->timestamp('email_verified_at')->nullable(); // Marca de tiempo opcional para verificar el correo

            $table->string('password'); // Contraseña del usuario

            $table->string('cargo'); // Cargo del usuario dentro de la organización

            $table->string('firma'); // Firma del usuario (ruta de la imagen)

            $table->string('rol')->default('usuario'); // Rol del usuario, con valor predeterminado de "usuario"

            $table->boolean('estado')->default(true); // Estado del usuario, con valor predeterminado de true (activo)

            $table->rememberToken(); // Token de recuerdo para sesiones persistentes

            $table->timestamps(); // Campos de marcas de tiempo automáticos (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabla users si se realiza un rollback de la migración
        Schema::dropIfExists('users');
    }
};
