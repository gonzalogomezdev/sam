<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras Sociales</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
</head>
<body>
<div class="container mt-5">
    <h1>Obras Sociales</h1>

    <!-- Mensajes de éxito -->
    <div id="successMessage" class="alert alert-success d-none"></div>

    <!-- Botón para agregar nueva obra social -->
    <button id="addObraSocial" class="btn btn-primary mb-3">Agregar Nueva Obra Social</button>

    <!-- Tabla de obras sociales -->
    <table id="obrasSocialesTable" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($obrasSociales as $obraSocial)
                <tr>
                    <td>{{ $obraSocial->id }}</td>
                    <td>{{ $obraSocial->Nombre }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $obraSocial->id }}" data-nombre="{{ $obraSocial->Nombre }}">Editar</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $obraSocial->id }}">Eliminar</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay obras sociales disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal para agregar/editar obra social -->
<div class="modal fade" id="obraSocialModal" tabindex="-1" aria-labelledby="obraSocialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="obraSocialModalLabel">Agregar Obra Social</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="obraSocialForm" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="Nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="Nombre" name="Nombre" required>
                    </div>
                    <input type="hidden" id="obraSocialId" name="obraSocialId">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmación de eliminación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar esta obra social?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const obraSocialForm = document.getElementById('obraSocialForm');
        const nombreInput = document.getElementById('Nombre');
        const obraSocialIdInput = document.getElementById('obraSocialId');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        let deleteId = null;

        // Botón para agregar nueva obra social
        document.getElementById('addObraSocial').addEventListener('click', function () {
            obraSocialForm.reset();
            obraSocialIdInput.value = '';
            obraSocialForm.action = '{{ route('social.add') }}';
            const methodInput = document.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.remove();
            }
            document.getElementById('obraSocialModalLabel').innerText = 'Agregar Obra Social';
            new bootstrap.Modal(document.getElementById('obraSocialModal')).show();
        });

        // Evento para editar obra social
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const obraSocialId = this.dataset.id;
                const obraSocialNombre = this.dataset.nombre;
                nombreInput.value = obraSocialNombre;
                obraSocialIdInput.value = obraSocialId;
                obraSocialForm.action = `/social/${obraSocialId}`;
                if (!document.querySelector('input[name="_method"]')) {
                    obraSocialForm.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
                }
                document.getElementById('obraSocialModalLabel').innerText = 'Editar Obra Social';
                new bootstrap.Modal(document.getElementById('obraSocialModal')).show();
            });
        });

        // Evento para eliminar obra social
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                deleteId = this.dataset.id;
                new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
            });
        });

        // Confirmar eliminación
        confirmDeleteButton.addEventListener('click', function () {
            fetch(`/social/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      location.reload();
                  } else {
                      alert('Error al eliminar la obra social.');
                  }
              });
        });

        // Envío del formulario para agregar/editar obra social
        obraSocialForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(obraSocialForm);
            fetch(obraSocialForm.action, {
                method: formData.get('obraSocialId') ? 'PUT' : 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      location.reload();
                  } else {
                      alert('Error al guardar la obra social.');
                  }
              });
        });
    });
</script>
</body>
</html>
