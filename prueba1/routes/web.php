<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyectoController;

Route::get('/', function () {
    return view('auth');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/principal', function () {
    return view('principal');
})->middleware('auth');

Route::get('/admin/usuarios', function () {
    return view('admin.usuarios');
})->name('admin.usuarios');

// Rutas agrupadas que  requieren estar logueado
Route::middleware('auth')->group(function () {

    // ver los proyectos
    Route::get('/principal', [ProyectoController::class, 'index'])->name('principal');

    // guardar un proyecto nuevo
    Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');

    Route::get('/proyectos/{id}', [App\Http\Controllers\ProyectoController::class, 'show'])->name('proyectos.show');

    // actualizar el estado de una tarea
    Route::patch('/tareas/{id}/estado', [App\Http\Controllers\ProyectoController::class, 'updateTareaEstado']);

    Route::get('/proyectos/{id}/colaboradores', [App\Http\Controllers\ProyectoController::class, 'colaboradores'])->name('proyectos.colaboradores');
    Route::post('/proyectos/{id}/colaboradores', [App\Http\Controllers\ProyectoController::class, 'addColaborador'])->name('proyectos.colaboradores.add');

    // cerrar sesión
    Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

    // guardar una nueva tarea
    Route::post('/tareas', [App\Http\Controllers\ProyectoController::class, 'storeTarea'])->name('tareas.store');
});
