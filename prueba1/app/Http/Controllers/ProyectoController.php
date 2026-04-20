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
}
