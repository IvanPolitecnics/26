<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\UsuarioApiController;
use App\Models\Usuario;

Route::middleware(['auth', 'admin'])->get('/usuarios', [UsuarioApiController::class, 'index']);


Route::get('/usuarios', function () {
    return response()->json(
        Usuario::select('id','nombre','email')->get()
    );
});
