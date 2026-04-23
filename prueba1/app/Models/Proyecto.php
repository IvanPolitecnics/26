<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    // nombre de la tabla
    protected $table = 'proyectos';

    // campos que permitimos rellenar masivamente
    protected $fillable = ['nombre', 'descripcion', 'creado_por'];

    // relacion un proyecto pertenece a un creador (usuario)
    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    // relacion un proyecto tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'proyecto_id');
    }

    // relacion un proyecto tiene muchos colaboradores (miembros_proyecto)
    public function colaboradores()
    {
        // belongsToMany(Modelo, 'tabla_intermedia', 'clave_foranea_origen', 'clave_foranea_destino')
        return $this->belongsToMany(Usuario::class, 'miembros_proyecto', 'proyecto_id', 'usuario_id');
    }
}
