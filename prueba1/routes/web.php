<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
