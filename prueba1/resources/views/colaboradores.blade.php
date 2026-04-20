@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary">Gestionar Colaboradores</h2>
        <a href="{{ route('principal') }}" class="btn btn-outline-secondary">Volver a Mis Proyectos</a>
    </div>

    <h5 class="text-muted mb-4">Proyecto: <strong>{{ $proyecto->nombre }}</strong></h5>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title fw-bold text-success">Ya son colaboradores</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse($proyecto->colaboradores as $colaborador)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <span class="fw-bold">{{ $colaborador->nombre }}</span><br>
                                    <small class="text-muted">{{ $colaborador->email }}</small>
                                </div>
                                <span class="badge bg-success rounded-pill">Activo</span>
                            </li>
                        @empty
                            <div class="alert alert-light text-center border mt-2" role="alert">
                                No hay colaboradores adicionales aún.
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="card-title fw-bold text-primary">Añadir Colaborador</h5>
                    <small class="text-muted">Lista cargada dinámicamente desde tu API</small>
                </div>
                <div class="card-body">

                    <ul id="lista-usuarios-api" class="list-group list-group-flush">
                        <li class="list-group-item text-center text-muted border-0 mt-3">
                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                            Cargando usuarios...
                        </li>
                    </ul>

                    <form id="form-add-colaborador" action="{{ route('proyectos.colaboradores.add', $proyecto->id) }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="usuario_id" id="input-usuario-id">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Petición a tu API
            fetch("{{ url('api/usuarios') }}")
                .then(response => response.json())
                .then(usuarios => {
                    const lista = document.getElementById('lista-usuarios-api');
                    lista.innerHTML = ''; // Limpiamos el texto de "Cargando..."

                    // El creador del proyecto
                    const creadorId = {{ $proyecto->creado_por }};

                    // Magia de Blade: Convertimos los IDs de los colaboradores actuales a un array de JavaScript
                    const colaboradoresActuales = @json($proyecto->colaboradores->pluck('id'));

                    let usuariosDisponibles = 0;

                    usuarios.forEach(usuario => {
                        // Solo mostramos al usuario si NO es el creador y NO está ya en la lista de colaboradores
                        if (usuario.id !== creadorId && !colaboradoresActuales.includes(usuario.id)) {
                            usuariosDisponibles++;

                            const li = document.createElement('li');
                            li.className = 'list-group-item d-flex justify-content-between align-items-center px-0 py-3';
                            li.innerHTML = `
                                <div>
                                    <span class="fw-bold">${usuario.nombre}</span><br>
                                    <small class="text-muted">${usuario.email}</small>
                                </div>
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="añadirUsuario(${usuario.id})">
                                    + Añadir
                                </button>
                            `;
                            lista.appendChild(li);
                        }
                    });

                    // Si todos los usuarios ya están en el proyecto, mostramos un mensaje
                    if (usuariosDisponibles === 0) {
                        lista.innerHTML = `
                            <div class="alert alert-light text-center border mt-2" role="alert">
                                Ya has invitado a todos los usuarios registrados.
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('lista-usuarios-api').innerHTML = `
                        <div class="alert alert-danger mt-2" role="alert">
                            Error al cargar la lista de usuarios.
                        </div>
                    `;
                    console.error("Error en la API:", error);
                });
        });

        // Función que se ejecuta al darle al botón "Añadir"
        function añadirUsuario(id) {
            document.getElementById('input-usuario-id').value = id;
            document.getElementById('form-add-colaborador').submit();
        }
    </script>
@endsection









{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Colaboradores - {{ $proyecto->nombre }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .grid { display: flex; gap: 40px; }
        .box { border: 1px solid #ccc; padding: 20px; border-radius: 5px; min-width: 300px; }
        ul { list-style: none; padding: 0; }
        li { padding: 8px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between;}
    </style>
</head>
<body>
    <h1>Gestionar Colaboradores: {{ $proyecto->nombre }}</h1>
    <a href="{{ route('principal') }}">Volver a Mis Proyectos</a>
    <hr>

    <div class="grid">
        <div class="box">
            <h3>Ya son colaboradores</h3>
            <ul>
                @forelse($proyecto->colaboradores as $colaborador)
                    <li>
                        <span>{{ $colaborador->nombre }} ({{ $colaborador->email }})</span>
                    </li>
                @empty
                    <li>No hay colaboradores aún.</li>
                @endforelse
            </ul>
        </div>

        <div class="box">
            <h3>Añadir Colaborador</h3>
            <p style="font-size: 12px; color: gray;">Lista cargada desde la API</p>
            <ul id="lista-usuarios-api">
                <li>Cargando usuarios...</li>
            </ul>

            <form id="form-add-colaborador" action="{{ route('proyectos.colaboradores.add', $proyecto->id) }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="usuario_id" id="input-usuario-id">
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hacemos una petición a tu API (ruta api/usuarios)
            fetch("{{ url('api/usuarios') }}")
                .then(response => response.json())
                .then(usuarios => {
                    const lista = document.getElementById('lista-usuarios-api');
                    lista.innerHTML = ''; // Limpiamos el texto de "Cargando..."

                    // Creador del proyecto para no mostrarlo en la lista de "Añadir"
                    const creadorId = {{ $proyecto->creado_por }};

                    usuarios.forEach(usuario => {
                        // Omitimos al creador original de la lista
                        if (usuario.id !== creadorId) {
                            const li = document.createElement('li');
                            li.innerHTML = `
                                <span>${usuario.nombre}</span>
                                <button onclick="añadirUsuario(${usuario.id})">Añadir</button>
                            `;
                            lista.appendChild(li);
                        }
                    });
                })
                .catch(error => {
                    document.getElementById('lista-usuarios-api').innerHTML = '<li>Error al cargar usuarios</li>';
                    console.error("Error en la API:", error);
                });
        });

        // Función que se ejecuta al darle al botón "Añadir"
        function añadirUsuario(id) {
            document.getElementById('input-usuario-id').value = id;
            document.getElementById('form-add-colaborador').submit();
        }
    </script>
</body>
</html> --}}
