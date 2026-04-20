<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;

class ProyectoController extends Controller
{
    // Función para mostrar la lista de proyectos en la vista principal
    public function index()
    {
        // Obtenemos los proyectos creados por el usuario logueado
        $proyectos = Proyecto::where('creado_por', Auth::id())->get();

        // Retornamos la vista 'principal' pasándole la variable $proyectos
        return view('principal', compact('proyectos'));
    }

    // Función para guardar un nuevo proyecto
    public function store(Request $request)
    {
        // Validamos que el nombre sea obligatorio
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        // Creamos el proyecto
        Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion, // Puede ser nulo
            'creado_por' => Auth::id() // El ID del usuario que está en sesión
        ]);

        // Redirigimos de vuelta a la página principal
        return redirect()->route('principal');
    }

    // Mostrar el tablero Kanban de un proyecto
    public function show($id)
    {
        // Buscamos el proyecto con sus tareas
        $proyecto = Proyecto::with('tareas')->findOrFail($id);

        return view('tablero', compact('proyecto'));
    }

    // Actualizar el estado de la tarea al arrastrarla
    public function updateTareaEstado(Request $request, $id)
    {
        // Validamos que nos envíen un estado válido
        $request->validate([
            'estado_id' => 'required|integer'
        ]);

        // Buscamos la tarea y le cambiamos el estado
        $tarea = \App\Models\Tarea::findOrFail($id);
        $tarea->estado_id = $request->estado_id;
        $tarea->save();

        // Devolvemos una respuesta correcta en formato JSON
        return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    }
}
