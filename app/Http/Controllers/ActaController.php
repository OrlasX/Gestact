<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Acta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Asistente;
use App\Models\Ausente;
use App\Models\Invitado;
use App\Models\OrdenDia;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ActaController extends Controller
{
    // Método para mostrar el formulario de redacción del acta
    public function createRedactar(Request $request)
    {
        // Obtener la lista de usuarios activos que no son auxiliares y ordenarlos por nombre
        $usuarios = User::where('estado', true)
                        ->where('rol', '!=', 'auxiliar')
                        ->orderBy('name')
                        ->get(['id', 'name', 'cargo']); // Asegúrate de incluir 'id'

        // Si hay IDs de asistentes ya seleccionados, filtrar la lista
        if ($request->filled('asistentes_ids')) {
            $asistentesIds = $request->input('asistentes_ids');
            $usuarios = $usuarios->whereNotIn('id', $asistentesIds);
        }

        // Retornar la vista de redacción con la lista de usuarios
        return view('plantilla.redactar', compact('usuarios'));
    }


   // Método para mostrar un acta en la vista de edición
public function show($id)
{
    // Buscar el acta por ID y guardar la URL previa en la sesión
    $acta = Acta::findOrFail($id);
    $previousUrl = url()->previous();
    session(['previous_url' => $previousUrl]);

    // Agrega un log para verificar la URL previa
    \Log::info('Previous URL: ' . $previousUrl);

    // Obtener la lista de asistentes del acta y usuarios activos no auxiliares
    $asistentes = Asistente::where('acta_id', $id)->get();
    $usuarios = User::where('estado', true)
                    ->where('rol', '!=', 'auxiliar')
                    ->orderBy('name')
                    ->get(['name', 'cargo']);

    // Verificar si todos los asistentes han firmado el acta
    $todosFirmaron = $asistentes->every(function ($asistente) {
        return $asistente->firmado === true;
    });

    // Retornar la vista con los datos del acta, asistentes, y el estado de firmas
    return view('plantilla.show', compact('acta', 'usuarios', 'asistentes', 'todosFirmaron'));
}

    public function firmar(Request $request, $id)
    {
        // Obtener el acta por su ID
        $acta = Acta::findOrFail($id);

        // Verificar que el acta sea editable
        if (!$acta->editable) {
            return redirect()->back()->with('error', 'El acta ya no es editable.');
        }

        // Verificar que el usuario actual es un asistente de este acta y que no ha firmado
        $asistente = $acta->asistentes()->where('nombre', auth()->user()->name)->where('firmado', false)->first();

        if ($asistente) {
            // Marcar el asistente como firmado y guardar
            $asistente->firmado = true;
            $asistente->save();

            return redirect()->route('acta.show', $id);
        }

        // Si no es un asistente válido o ya firmó, redirigir con mensaje de error
        return redirect()->back()->with('error', 'No tienes permisos para firmar este acta o ya has firmado.');
    }



    // Método para actualizar la información de un acta
    public function update(Request $request, $id)
    {

        //dd("dsdsds");
        // Buscar el acta por ID y actualizar sus atributos básicos
        $acta = Acta::findOrFail($id);
        $acta->nombre = $request->input('nombre');
        $acta->apodo = $request->input('apodo');
        $acta->identificacion = $request->input('identificacion');
        $acta->fecha_reunion = $request->input('fecha_reunion');
        $acta->hora_inicial = $request->input('hora_inicial');
        $acta->hora_final = $request->input('hora_final');
        $acta->lugar_reunion = $request->input('lugar_reunion');
        $acta->proxima_reunion = $request->input('proxima_reunion');
        $acta->save();


        if ($request->has('asistentes')) {
            $asistentesExistentes = $acta->asistentes; // Obtener todos los asistentes existentes
            $nuevosAsistentes = $request->input('asistentes');
            $nuevosCargosAsistentes = $request->input('cargos_asistentes');

            // Arreglo para almacenar los IDs de asistentes que deben permanecer
            $asistentesIdsParaGuardar = [];

            foreach ($nuevosAsistentes as $index => $nombre) {
                $nombre = trim($nombre) === '' ? null : $nombre;
                $cargo = trim($nuevosCargosAsistentes[$index] ?? '') === '' ? null : $nuevosCargosAsistentes[$index];

                // Verificar si ya existe un asistente con el mismo nombre
                $asistenteExistente = $asistentesExistentes->firstWhere('nombre', $nombre);

                if ($asistenteExistente) {
                    // Actualizar asistente existente, manteniendo el atributo firmado
                    $asistenteExistente->update([
                        'cargo' => $cargo,
                        // No modificar 'firmado' aquí
                    ]);
                    // Agregar ID del asistente existente a la lista
                    $asistentesIdsParaGuardar[] = $asistenteExistente->id;
                } else {
                    // Crear nuevo asistente y asociarlo al acta con firmado en false
                    $asistente = new Asistente([
                        'nombre' => $nombre,
                        'cargo' => $cargo,
                        'firmado' => false, // Establecer firmado como false para nuevos asistentes
                    ]);
                    $acta->asistentes()->save($asistente);
                    // Agregar ID del nuevo asistente a la lista
                    $asistentesIdsParaGuardar[] = $asistente->id;
                }
            }

            // Ahora eliminamos asistentes que ya no están en la lista nueva
            $idsEliminar = $asistentesExistentes->whereNotIn('id', $asistentesIdsParaGuardar)->pluck('id');
            if ($idsEliminar->isNotEmpty()) {
                Asistente::whereIn('id', $idsEliminar)->delete();
            }
        }



        // Actualización de ausentes
        if ($request->has('ausentes')) {
            $ausentesExistentes = $acta->ausentes;
            $nuevosAusentes = $request->input('ausentes');
            $nuevosCargosAusentes = $request->input('cargos_ausentes');

            foreach ($nuevosAusentes as $index => $nombre) {
                $nombre = trim($nombre) === '' ? null : $nombre;
                $cargo = trim($nuevosCargosAusentes[$index] ?? '') === '' ? null : $nuevosCargosAusentes[$index];

                if (isset($ausentesExistentes[$index])) {
                    // Actualizar ausente existente
                    $ausentesExistentes[$index]->update([
                        'nombre' => $nombre,
                        'cargo' => $cargo,
                    ]);
                } else {
                    // Crear nuevo ausente y asociarlo al acta
                    $ausente = new Ausente([
                        'nombre' => $nombre,
                        'cargo' => $cargo,
                    ]);
                    $acta->ausentes()->save($ausente);
                }
            }

            // Eliminar ausentes sobrantes si la cantidad cambió
            if (count($ausentesExistentes) > count($nuevosAusentes)) {
                $idsEliminar = $ausentesExistentes->slice(count($nuevosAusentes))->pluck('id');
                Ausente::whereIn('id', $idsEliminar)->delete();
            }
        }

        // Actualización de invitados (similar a asistentes y ausentes)
        if ($request->has('invitados')) {
            $invitadosExistentes = $acta->invitados;
            $nuevosInvitados = $request->input('invitados');
            $nuevosCargosInvitados = $request->input('cargos_invitados');

            foreach ($nuevosInvitados as $index => $nombre) {
                $nombre = trim($nombre) === '' ? null : $nombre;
                $cargo = trim($nuevosCargosInvitados[$index] ?? '') === '' ? null : $nuevosCargosInvitados[$index];

                if (isset($invitadosExistentes[$index])) {
                    $invitadosExistentes[$index]->update([
                        'nombre' => $nombre,
                        'cargo' => $cargo,
                    ]);
                } else {
                    $invitado = new Invitado([
                        'nombre' => $nombre,
                        'cargo' => $cargo,
                    ]);
                    $acta->invitados()->save($invitado);
                }
            }

            if (count($invitadosExistentes) > count($nuevosInvitados)) {
                $idsEliminar = $invitadosExistentes->slice(count($nuevosInvitados))->pluck('id');
                Invitado::whereIn('id', $idsEliminar)->delete();
            }
        }

        // Actualización de puntos del orden del día
        if ($request->has('orden_del_dia')) {
            $ordenesExistentes = $acta->orden_del_dia;
            $nuevosOrdenes = $request->input('orden_del_dia');

            foreach ($nuevosOrdenes as $index => $nombre) {
                $descripcion = $request->input('descripcion_orden')[$index] ?? '';

                if (isset($ordenesExistentes[$index])) {
                    $ordenesExistentes[$index]->update([
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                    ]);
                } else {
                    $orden = new OrdenDia([
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                    ]);
                    $acta->orden_del_dia()->save($orden);
                }
            }

            if (count($ordenesExistentes) > count($nuevosOrdenes)) {
                $idsEliminar = $ordenesExistentes->slice(count($nuevosOrdenes))->pluck('id');
                OrdenDia::whereIn('id', $idsEliminar)->delete();
            }
        }

        // Redirigir al dashboard con el ID del acta actualizada
        return redirect()->route('dashboard');

    }


    //metodo para la creacion de un acta
    public function store(Request $request)
    {
        // Validación de los datos del formulario


        // Definición de variables que pueden ser nulas
        $ausentes = $request->input('ausentes') ?? null;
        $cargosAusentes = $request->input('cargos_ausentes') ?? null;
        $invitados = $request->input('invitados') ?? null;
        $cargosInvitados = $request->input('cargos_invitados') ?? null;
        $ordenDelDia = $request->input('orden_del_dia');
        $descripcionOrden = $request->input('descripcion_orden');

        // Creación de un nuevo acta con los datos básicos
        $acta = Acta::create([
            'nombre' => $request->nombre,
            'apodo' => $request->apodo,
            'identificacion' => $request->identificacion,
            'fecha_reunion' => $request->fecha_reunion,
            'hora_inicial' => $request->hora_inicial,
            'hora_final' => $request->hora_final,
            'lugar_reunion' => $request->lugar_reunion,
            'proxima_reunion' => $request->proxima_reunion,
            'user_id' => auth()->user()->id, // El usuario actual que crea el acta
            'editable' => true, // Establece el acta como editable inicialmente
        ]);

        // Guardado de cada asistente con su respectivo cargo
        foreach ($request->asistentes as $index => $nombre) {
            $acta->asistentes()->create([
                'nombre' => $nombre,
                'cargo' => $request->cargos_asistentes[$index],
            ]);
        }

        // Guardado de los ausentes si existen en la entrada
        if ($ausentes) {
            foreach ($ausentes as $index => $nombre) {
                $acta->ausentes()->create([
                    'nombre' => $nombre,
                    'cargo' => $cargosAusentes[$index] ?? null,
                ]);
            }
        }

        // Guardado de los invitados si existen en la entrada
        if ($invitados) {
            foreach ($invitados as $index => $nombre) {
                $acta->invitados()->create([
                    'nombre' => $nombre,
                    'cargo' => $cargosInvitados[$index] ?? null,
                ]);
            }
        }

        // Guardado de cada tema y su descripción del orden del día
        foreach ($ordenDelDia as $index => $nombre) {
            $acta->orden_del_dia()->create([
                'nombre' => $nombre,
                'descripcion' => $descripcionOrden[$index],
            ]);
        }

        // Redirección al dashboard después de guardar el acta
        return redirect()->route('dashboard');
    }

    //metodo para eliminar un acta
    public function destroy($id)
    {
        // Busca el acta por su ID y lanza una excepción si no se encuentra
        $acta = Acta::findOrFail($id);

        // Elimina el registro del acta en la base de datos
        $acta->delete();

        // Redirecciona al dashboard tras eliminar el acta
        return redirect()->route('dashboard');
    }


    //metodo para generar el acta y dejarla solo para lectura
    public function generar($id)
    {
        // Busca el acta con el ID dado, lanzando una excepción si no se encuentra
        $acta = Acta::findOrFail($id);

            // Si todos firmaron, cambia el estado a no editable
            $acta->editable = false;
            $acta->save(); // Guarda los cambios en la base de datos




        return redirect()->route('dashboard', $id);
    }

    //metodo para descargar el pdf
    public function download($id)
    {
        $acta = Acta::with('asistentes')->findOrFail($id);

        // Aquí se generar el PDF usando DomPDF
        $pdf = \PDF::loadView('plantilla.pdf', compact('acta'));

        // Retornar el PDF como descarga
        return $pdf->download($acta->nombre. '.pdf');
    }


    //metodo para realizar una busqueda
    public function buscar(Request $request)
    {
        // Guarda la ruta en la sesión para el botón de "Volver"


        session(['last_dashboard_or_search_url' => url()->full()]);

        // Inicializa una nueva consulta para el modelo Acta
        $query = Acta::query();

        // Filtros de año, mes y día para la fecha de reunión
        if ($request->filled('year')) {
            $query->whereYear('fecha_reunion', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('fecha_reunion', $request->month);
        }
        if ($request->filled('day')) {
            $query->whereDay('fecha_reunion', $request->day);
        }

        // Filtros de hora para la reunión
        if ($request->filled('hora_inicial')) {
            $query->whereTime('hora_inicial', '>=', $request->hora_inicial);
        }
        if ($request->filled('hora_final')) {
            $query->whereTime('hora_final', '<=', $request->hora_final);
        }

        // Filtro por apodo
        if ($request->filled('apodo')) {
            $query->where('apodo', 'LIKE', '%' . $request->apodo . '%');
        }

        // Filtro por asistentes y sus cargos
        if ($request->filled('asistentes') && $request->filled('cargos_asistentes')) {
            $asistentes = $request->input('asistentes');
            $cargos = $request->input('cargos_asistentes');

            foreach ($asistentes as $index => $nombre) {
                if (!empty($nombre) && isset($cargos[$index])) {
                    $cargo = $cargos[$index];
                    $query->whereHas('asistentes', function ($subQuery) use ($nombre, $cargo) {
                        $subQuery->where('nombre', $nombre)
                            ->where('cargo', $cargo);
                    });
                }
            }
        }

        // Filtro por texto en el orden del día
        if ($request->filled('texto')) {
            $query->whereHas('orden_del_dia', function ($subQuery) use ($request) {
                $subQuery->whereRaw('LOWER(descripcion) LIKE LOWER(?)', ['%' . $request->texto . '%']);
            });
        }

        // Filtro por lugar de la reunión
        if ($request->filled('lugar')) {
            $query->where('lugar_reunion', 'LIKE', '%' . $request->lugar . '%');
        }

        // Ejecuta la consulta y obtiene las actas, ordenadas por ID de forma descendente
        $actas = $query->orderByDesc('id')->get();

        // Obtiene la lista de todos los usuarios y sus cargos
        $usuarios = User::all(['name', 'cargo']);

        return view('plantilla.busqueda', [
            'actas' => $actas,
            'usuarios' => $usuarios,
            'mensaje' => $actas->isEmpty() ? 'No se encontraron actas.' : null,
            'search_filters' => $request->all()  // Pasa los filtros actuales a la vista
        ]);
    }



    //metodo para que envia a la vista de buscar los usuarios
    public function showBuscarForm()
    {
        // Obtener todos los usuarios (activos y desactivados) que no sean auxiliares
        $usuarios = User::where('rol', '!=', 'auxiliar') // Filtra los usuarios excluyendo aquellos con rol 'auxiliar'
                        ->orderBy('name') // Ordena los resultados por el campo 'name' de forma ascendente
                        ->get(['id', 'name', 'cargo']); // Recupera solo los campos 'id', 'name' y 'cargo' de cada usuario

        // Devuelve la vista 'plantilla.buscar', pasando la lista de usuarios a la vista
        return view('plantilla.buscar', ['usuarios' => $usuarios]);
    }

}
