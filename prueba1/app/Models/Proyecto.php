<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // Le indicamos exactamente el nombre de la tabla
    protected $table = 'proyectos';

    // Los campos que permitimos rellenar masivamente
    protected $fillable = ['nombre', 'descripcion', 'creado_por'];

    // Relación: Un proyecto pertenece a un creador (usuario)
    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }
}
