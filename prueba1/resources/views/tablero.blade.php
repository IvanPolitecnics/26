@extends('layout')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .kanban-board {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            overflow-x: auto;
            padding-bottom: 1rem;
        }
        .kanban-column {
            background-color: #f4f5f7;
            border-radius: 0.5rem;
            min-width: 320px;
            width: 320px;
            min-height: 450px;
        }
        .kanban-task {
            cursor: grab;
            transition: transform 0.1s ease, box-shadow 0.1s ease;
        }
        .kanban-task:active {
            cursor: grabbing;
            transform: scale(0.98);
        }
        .drag-over {
            background-color: #e2e4e9;
            border: 2px dashed #adb5bd;
        }
        .quick-add-wrapper {
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-primary">Tablero: {{ $proyecto->nombre }}</h2>
        </div>
        <a href="{{ route('principal') }}" class="btn btn-outline-secondary">Volver a Mis Proyectos</a>
    </div>

    <div class="kanban-board mb-5">

        <div class="kanban-column p-3 shadow-sm" data-estado="1">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="fw-bold text-secondary mb-0">To Do</h5>
            </div>
            <div class="kanban-items">
                @foreach($proyecto->tareas->where('estado_id', 1) as $tarea)
                    <div class="kanban-task card border-0 shadow-sm mb-3" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                        <div class="card-body p-3">
                            @php
                                $colorBadge = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'bg-warning text-dark',
                                    12 => 'bg-danger',
                                    13 => 'bg-info text-dark',
                                    default => 'bg-secondary',
                                };
                                $nombreTipo = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'Diseño',
                                    12 => 'Backend',
                                    13 => 'Frontend',
                                    default => 'General',
                                };
                            @endphp
                            <span class="badge {{ $colorBadge }} mb-2" style="font-size: 0.7rem;">{{ $nombreTipo }}</span>
                            <h6 class="card-title fw-bold mb-1">{{ $tarea->titulo }}</h6>
                            <p class="card-text text-muted small mb-0">{{ $tarea->descripcion }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="kanban-column p-3 shadow-sm" data-estado="2">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="fw-bold text-primary mb-0">In Progress</h5>
            </div>
            <div class="kanban-items">
                @foreach($proyecto->tareas->where('estado_id', 2) as $tarea)
                    <div class="kanban-task card border-0 shadow-sm mb-3" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                        <div class="card-body p-3">
                            @php
                                $colorBadge = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'bg-warning text-dark',
                                    12 => 'bg-danger',
                                    13 => 'bg-info text-dark',
                                    default => 'bg-secondary',
                                };
                                $nombreTipo = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'Diseño',
                                    12 => 'Backend',
                                    13 => 'Frontend',
                                    default => 'General',
                                };
                            @endphp
                            <span class="badge {{ $colorBadge }} mb-2" style="font-size: 0.7rem;">{{ $nombreTipo }}</span>
                            <h6 class="card-title fw-bold mb-1">{{ $tarea->titulo }}</h6>
                            <p class="card-text text-muted small mb-0">{{ $tarea->descripcion }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="kanban-column p-3 shadow-sm" data-estado="3">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h5 class="fw-bold text-success mb-0">Done</h5>
            </div>
            <div class="kanban-items">
                @foreach($proyecto->tareas->where('estado_id', 3) as $tarea)
                    <div class="kanban-task card border-0 shadow-sm mb-3" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                        <div class="card-body p-3">
                            @php
                                $colorBadge = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'bg-warning text-dark',
                                    12 => 'bg-danger',
                                    13 => 'bg-info text-dark',
                                    default => 'bg-secondary',
                                };
                                $nombreTipo = match((int)$tarea->tipo_tarea_id) {
                                    11 => 'Diseño',
                                    12 => 'Backend',
                                    13 => 'Frontend',
                                    default => 'General',
                                };
                            @endphp
                            <span class="badge {{ $colorBadge }} mb-2" style="font-size: 0.7rem;">{{ $nombreTipo }}</span>
                            <h6 class="card-title fw-bold mb-1">{{ $tarea->titulo }}</h6>
                            <p class="card-text text-muted small mb-0">{{ $tarea->descripcion }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="quick-add-wrapper p-4 shadow-sm">
        <h5 class="fw-bold mb-3">Añadir Nueva Tarea</h5>
        <form action="{{ route('tareas.store') }}" method="POST" class="row g-3">
            @csrf
            <input type="hidden" name="proyecto_id" value="{{ $proyecto->id }}">

            <div class="col-md-4">
                <label class="form-label small fw-bold">Título</label>
                <input type="text" name="titulo" class="form-control" placeholder="Nombre" required>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold">Tipo de Tarea</label>
                <select name="tipo_tarea_id" class="form-select" required>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold">Descripción</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Descripcion">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Crear Tarea</button>
            </div>
        </form>
    </div>

    <script>
        // script de arrastre
        const tasks = document.querySelectorAll('.kanban-task');
        const columns = document.querySelectorAll('.kanban-column');
        let draggedTask = null;

        tasks.forEach(task => {
            task.addEventListener('dragstart', function() {
                draggedTask = task;
                setTimeout(() => task.style.display = 'none', 0);
            });

            task.addEventListener('dragend', function() {
                setTimeout(() => {
                    if(draggedTask) draggedTask.style.display = 'block';
                    draggedTask = null;
                }, 0);
            });
        });

        columns.forEach(column => {
            column.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });

            column.addEventListener('dragleave', function() {
                this.classList.remove('drag-over');
            });

            column.addEventListener('drop', function() {
                this.classList.remove('drag-over');
                if (!draggedTask) return;

                const itemsContainer = this.querySelector('.kanban-items');
                itemsContainer.append(draggedTask);

                const tareaId = draggedTask.getAttribute('data-id');
                const nuevoEstado = this.getAttribute('data-estado');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`{{ url('tareas') }}/${tareaId}/estado`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ estado_id: nuevoEstado })
                })
                .then(response => response.json())
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection




{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>Tablero - {{ $proyecto->nombre }}</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f5f7; }
        .board { display: flex; gap: 20px; padding: 20px; align-items: flex-start; }
        .column {
            background-color: #ebecf0;
            border-radius: 5px;
            width: 300px;
            min-height: 400px;
            padding: 10px;
        }
        .column h3 { text-align: center; margin-top: 0; color: #333; }
        .task {
            background-color: white;
            padding: 15px;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            margin-bottom: 10px;
            cursor: grab;
        }
        .task:active { cursor: grabbing; }
        .drag-over { background-color: #d1d5db; /* Color al arrastrar por encima */ }
    </style>
</head>
<body>
    <div style="padding: 20px;">
        <h1>Proyecto: {{ $proyecto->nombre }}</h1>
        <a href="{{ route('principal') }}">Volver a Mis Proyectos</a>
    </div>

    <div class="board">
        <div class="column" id="col-todo" data-estado="1">
            <h3>To Do</h3>
            @foreach($proyecto->tareas->where('estado_id', 1) as $tarea)
                <div class="task" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                    <strong>{{ $tarea->titulo }}</strong>
                    <p style="font-size: 12px; color: gray;">{{ $tarea->descripcion }}</p>
                </div>
            @endforeach
        </div>

        <div class="column" id="col-inprogress" data-estado="2">
            <h3>In Progress</h3>
            @foreach($proyecto->tareas->where('estado_id', 2) as $tarea)
                <div class="task" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                    <strong>{{ $tarea->titulo }}</strong>
                    <p style="font-size: 12px; color: gray;">{{ $tarea->descripcion }}</p>
                </div>
            @endforeach
        </div>

        <div class="column" id="col-done" data-estado="3">
            <h3>Done</h3>
            @foreach($proyecto->tareas->where('estado_id', 3) as $tarea)
                <div class="task" draggable="true" id="task-{{ $tarea->id }}" data-id="{{ $tarea->id }}">
                    <strong>{{ $tarea->titulo }}</strong>
                    <p style="font-size: 12px; color: gray;">{{ $tarea->descripcion }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const tasks = document.querySelectorAll('.task');
        const columns = document.querySelectorAll('.column');
        let draggedTask = null;

        // Eventos para cada tarea
        tasks.forEach(task => {
            task.addEventListener('dragstart', function() {
                draggedTask = task;
                setTimeout(() => task.style.display = 'none', 0);
            });

            task.addEventListener('dragend', function() {
                setTimeout(() => {
                    draggedTask.style.display = 'block';
                    draggedTask = null;
                }, 0);
            });
        });

        // Eventos para cada columna
        columns.forEach(column => {
            column.addEventListener('dragover', function(e) {
                e.preventDefault(); // Necesario para permitir soltar
                this.classList.add('drag-over');
            });

            column.addEventListener('dragleave', function() {
                this.classList.remove('drag-over');
            });

            column.addEventListener('drop', function() {
                this.classList.remove('drag-over');

                // Si no hay tarea arrastrada, no hacemos nada
                if (!draggedTask) return;

                // Añadimos la tarea arrastrada a la nueva columna (efecto visual)
                this.append(draggedTask);

                // Obtenemos los datos para enviar a la base de datos
                const tareaId = draggedTask.getAttribute('data-id');
                const nuevoEstado = this.getAttribute('data-estado');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Enviamos la petición a Laravel en segundo plano
                fetch(`{{ url('tareas') }}/${tareaId}/estado`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ estado_id: nuevoEstado })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Guardado en base de datos:', data.message);
                })
                .catch(error => console.error('Error al guardar:', error));
            });
        });
    </script>
</body>
</html> --}}
