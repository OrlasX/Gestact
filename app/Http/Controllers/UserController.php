<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    // Método para activar un usuario
    public function activar($id)
    {
        // Busca el usuario por su ID, lanzando una excepción si no se encuentra
        $user = User::findOrFail($id);

        $user->estado = true; // Cambia el estado del usuario a activo
        $user->save(); // Guarda los cambios en la base de datos

        // Redirige a la ruta 'usuarios' después de activar el usuario
        return redirect()->route('usuarios');
    }

    // Método para desactivar un usuario
    public function desactivar($id)
    {
        // Busca el usuario por su ID, lanzando una excepción si no se encuentra
        $user = User::findOrFail($id);

        $user->estado = false; // Cambia el estado del usuario a inactivo
        $user->save(); // Guarda los cambios en la base de datos

        // Redirige a la ruta 'usuarios' después de desactivar el usuario
        return redirect()->route('usuarios');
    }

    // Método para listar todos los usuarios
    public function index()
    {
        // Obtiene todos los usuarios que no son auxiliares, ordenándolos por nombre
        $usuarios = User::where('rol', '!=', 'auxiliar')
                        ->orderBy('name')
                        ->get(); // Recupera todos los usuarios con la condición especificada

        // Devuelve la vista 'plantilla.usuarios', pasando la colección de usuarios a la vista
        return view('plantilla.usuarios', compact('usuarios'));
    }

}
