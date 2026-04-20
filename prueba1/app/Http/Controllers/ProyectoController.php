<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyectoController extends Controller
{
    // Muestra la lista de proyectos en la vista principal
    public function index()
    {
        $usuarioId = Auth::id();

        $proyectos = Proyecto::where('creado_por', $usuarioId)
            ->orWhereHas('colaboradores', function ($query) use ($usuarioId) {
                $query->where('usuarios.id', $usuarioId);
            })
            ->get();

        return view('principal', compact('proyectos'));
    }

    // Guarda un nuevo proyecto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        Proyecto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'creado_por' => Auth::id()
        ]);

        return redirect()->route('principal');
    }

    // Muestra el tablero Kanban (CORREGIDO con $tipos)
    public function show($id)
    {
        // Buscamos el proyecto con sus tareas
        $proyecto = Proyecto::with('tareas')->findOrFail($id);

        // Obtenemos los tipos de tareas para el formulario rápido
        // Asegúrate de que tu tabla se llame 'tipos_tareas' como en tu SQL manual
        $tipos = DB::table('tipos_tareas')->get();

        // Pasamos tanto el proyecto como los tipos a la vista
        return view('tablero', compact('proyecto', 'tipos'));
    }

    // Guarda una nueva tarea desde el tablero
    public function storeTarea(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'proyecto_id' => 'required|exists:proyectos,id',
            'tipo_tarea_id' => 'required'
        ]);

        Tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'proyecto_id' => $request->proyecto_id,
            'estado_id' => 1, // 'To Do' por defecto
            'tipo_tarea_id' => $request->tipo_tarea_id,
            'creador_id' => Auth::id(),
        ]);

        return back()->with('success', 'Tarea añadida correctamente');
    }

    // Actualiza el estado al arrastrar tareas
    public function updateTareaEstado(Request $request, $id)
    {
        $request->validate(['estado_id' => 'required|integer']);

        $tarea = Tarea::findOrFail($id);
        $tarea->estado_id = $request->estado_id;
        $tarea->save();

        return response()->json(['success' => true, 'message' => 'Estado actualizado']);
    }

    // Vista de colaboradores
    public function colaboradores($id)
    {
        $proyecto = Proyecto::with('colaboradores')->findOrFail($id);
        return view('colaboradores', compact('proyecto'));
    }

    // Añadir colaborador
    public function addColaborador(Request $request, $id)
    {
        $request->validate(['usuario_id' => 'required|integer']);
        $proyecto = Proyecto::findOrFail($id);

        if (!$proyecto->colaboradores->contains($request->usuario_id)) {
            $proyecto->colaboradores()->attach($request->usuario_id);
        }

        return back();
    }
}
