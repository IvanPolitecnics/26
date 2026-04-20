<!DOCTYPE html>
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
</html>
