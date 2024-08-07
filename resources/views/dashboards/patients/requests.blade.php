<style>
    .hidden-content-requests {
        display: none;
    }

    /* Eliminar los bordes entre las filas */
    .requests-table-wrapper .table {
        text-align: center;
    }

    tbody, td, tfoot, th, thead, tr {
        border: none;
    }

    .requests-table-wrapper .alta-btn-request, .requests-table-wrapper .baja-btn-request {
        padding: 7px 15px;
        border-radius: 25px;
        color: rgb(255,255,255);
        font-size: 14px;
    }

    .requests-table-wrapper .alta-btn-request {
        background-color: #4e73df;
    }

    .requests-table-wrapper .baja-btn-request {
        background-color: #dc3545;
    }

    .requests-table-wrapper .alta-btn-request:hover, .requests-table-wrapper .baja-btn-request:hover {
        opacity: 0.8;
        text-decoration: none;
        color: rgb(255,255,255);
    }

    .requests-table-wrapper .alta-btn-request.disabled, .requests-table-wrapper .baja-btn-request.disabled {
        opacity: 0.6; 
        pointer-events: none; 
        cursor: not-allowed;  
    }

    /* Estilos responsivos */
    @media (max-width: 767px) {
        .requests-table-wrapper .table thead {
            display: none;
        }
        .requests-table-wrapper .table, .requests-table-wrapper .table tbody, .requests-table-wrapper .table tr, .requests-table-wrapper .table td {
            display: block;
            width: 100%;
        }
        .requests-table-wrapper .table tr {
            margin-bottom: 1rem;
        }
        .requests-table-wrapper .table td {
            text-align: right;
        }
        .requests-table-wrapper .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 50%;
            padding-left: 15px;
            font-weight: bold;
            text-align: left;
        }
    }
</style>

<div class="container hidden-content-requests">
    <h1>Listado de Solicitudes</h1>
    @if (count($patients) > 0)
    <div class="requests-table-wrapper">
        <table id="requestsTable" class="table">
            <thead>
                <tr>
                    <th>Apellido y Nombre</th>
                    <th>DNI</th>
                    <th>Info. de Formulario</th>
                    <th>Alta</th>
                    <th>Baja</th>
                </tr>  
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                <tr>
                    <td data-label="Apellido y Nombre">{{ $patient->Apellido }} {{$patient->Nombre}}</td>
                    <td data-label="DNI">{{ $patient->DNI }}</td>
                    <td data-label="Info. de Formulario">
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modal-request-patient-{{ $patient->idPaciente }}"><i class="fa-regular fa-file-lines"></i></a>
                    </td>
                    <td data-label="Alta">
                      <a href="#" class="alta-btn-request" data-paciente-id="{{ $patient->idPaciente }}" data-url="{{ route('approve-userPatient') }}"><i class="fa-solid fa-user-plus"></i></a>
                    </td>
                    <td data-label="Baja">
                      <a href="#" class="baja-btn-request" data-url="{{ route('reject-userPatient', $patient->idPaciente) }}"><i class="fa-solid fa-user-xmark"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="emptyTable" style="display: none;">
        No hay datos disponibles por el momento.
    </div>
    @else
    <div id="emptyTableMessage">
        No hay datos disponibles por el momento.
    </div>
    @endif
</div>

@foreach ($patients as $patient)
<div class="modal fade requests-modal" id="modal-request-patient-{{ $patient->idPaciente }}" tabindex="-1" aria-labelledby="modal-request-patient" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center" id="modal-request-patient">Formulario de registro</h5>
            <button type="button" class="btn-close align-self-end" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
            <form>
                <div class="mb-3">
                  <label>Apellido</label>
                  <input type="text" class="form-control" value="{{ $patient->Apellido }}" readonly>
                </div>
                <div class="mb-3">
                  <label>Nombre</label>
                  <input type="text" class="form-control" value="{{ $patient->Nombre }}" readonly>
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="text" class="form-control" value="{{ $patient->user->Email }}" readonly>
                </div>
                <div class="mb-3">
                  <label>DNI</label>
                  <input type="text" class="form-control" value="{{ $patient->DNI }}" readonly>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endforeach

<script>
    $(document).ready(function () {
        var table = $('#requestsTable').DataTable({
            "order": [[0, 'desc']],
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        // Mostrar la tabla una vez que los datos estén cargados
        $('.hidden-content-requests').removeClass('hidden-content-requests');

        // Pasar el objeto `table` al script principal
        window.dataTable = table;
    });
</script>
<!-- Main Js -->
<script src="{{ asset('assets/js/patient/requests-main.js') }}"></script>
