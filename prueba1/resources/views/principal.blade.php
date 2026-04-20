<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Proyectos</title>
</head>
<body>
    <h1>Bienvenido, {{ Auth::user()->nombre }}</h1>

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
            </li>
        @empty
            <p>Todavía no tienes ningún proyecto. ¡Crea uno arriba!</p>
        @endforelse
    </ul>

</body>
</html>
