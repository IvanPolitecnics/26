<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';

    // campos que se pueden rellenar masivamente
    protected $fillable = [
        'titulo', 'descripcion', 'proyecto_id',
        'tipo_tarea_id', 'estado_id', 'creador_id', 'asignado_id'
    ];

    // una tarea pertenece a un estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
