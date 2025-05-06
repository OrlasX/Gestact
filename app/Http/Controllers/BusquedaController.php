<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusquedaController extends Controller
{

    public function busqueda()
{
    session(['last_dashboard_or_search' => route('busqueda')]);
        return view('plantilla.busqueda');
}
}
