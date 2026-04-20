<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
</head>
<body>
    <h1>PÁGINA PRINCIPAL</h1>
    <p>Has llegado correctamente después del login.</p>
    @if(auth()->user()->tipo_usuario_id == 1)
    <a href="{{ route('admin.usuarios') }}">
        <button>Ver usuarios</button>
    </a>
@endif

</body>
</html>
