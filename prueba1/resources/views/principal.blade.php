@extends('layout')

@section('content')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="card-title text-primary mb-3">Crear Nuevo Proyecto</h5>
            <form action="{{ route('proyectos.store') }}" method="POST" class="row g-3 align-items-center">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre del Proyecto" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <h3 class="mb-3">Mis Proyectos y Colaboraciones</h3>

    <div class="row">
        @forelse($proyectos as $proyecto)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $proyecto->nombre }}</h5>
                        <p class="card-text text-muted">
                            {{ $proyecto->descripcion ?? 'Sin descripción' }}
                        </p>
                        @if($proyecto->creado_por === Auth::id())
                            <span class="badge bg-primary mb-3">Creador</span>
                        @else
                            <span class="badge bg-info text-dark mb-3">Colaborador</span>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between">
                        <a href="{{ route('proyectos.show', $proyecto->id) }}" class="btn btn-outline-primary btn-sm">Tablero Kanban</a>
                        <a href="{{ route('proyectos.colaboradores', $proyecto->id) }}" class="btn btn-outline-secondary btn-sm">Colaboradores</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center" role="alert">
                    Todavía no tienes ningún proyecto. ¡Anímate a crear el primero arriba!
                </div>
            </div>
        @endforelse
    </div>

@endsection









{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Proyectos</title>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center;">
    <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>

    <a href="{{ route('logout') }}">
        <button type="button" style="background-color: #ff4d4d; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">
            Cerrar Sesión
        </button>
    </a>
</div>

    <hr>

    <h2>Crear Nuevo Proyecto</h2>
    <form action="{{ route('proyectos.store') }}" method="POST">
        @csrf
        <label for="nombre">Nombre del Proyecto:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion">

        <button type="submit">Crear Proyecto</button>
    </form>

    <hr>

    <h2>Mis Proyectos</h2>
    <ul>
        @forelse($proyectos as $proyecto)
            <li>
                <strong>{{ $proyecto->nombre }}</strong>
                @if($proyecto->descripcion)
                    <p>{{ $proyecto->descripcion }}</p>
                @endif
                <a href="{{ route('proyectos.show', $proyecto->id) }}">
                    <button type="button">Entrar al Tablero</button>
                </a>
                <a href="{{ route('proyectos.colaboradores', $proyecto->id) }}">
                    <button type="button">Gestionar Colaboradores</button>
                </a>
            </li>
        @empty
            <p>Todavía no tienes ningún proyecto. ¡Crea uno arriba!</p>
        @endforelse
    </ul>

</body>
</html> --}}
