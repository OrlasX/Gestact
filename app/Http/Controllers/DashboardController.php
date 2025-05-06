<?php

namespace App\Http\Controllers;

use App\Models\Acta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Almacena la ruta actual en la sesión para el botón de "Volver"
        session(['last_dashboard_or_search_url' => url()->full()]);

        // Obtén solo las últimas 24 actas ordenadas por fecha de creación
        $actas = Acta::latest()->take(24)->get();

        return view('dashboard', compact('actas'));
    }


}



