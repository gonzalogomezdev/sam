<style>
    .hidden-content-patients {
        display: none;
    }
    /* Estilos para pantallas pequeñas */
    @media (max-width: 767px) {
        .table-pt thead {
            display: none;
        }

        .table-pt, .table-pt tbody, .table-pt tr, .table-pt td {
            display: block;
            width: 100%;
            padding: 0px;
        }

        .table-pt tr {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd; /* Borde alrededor de cada "card" */
            border-radius: 5px; /* Esquinas redondeadas */
            background-color: #f9f9f9; /* Fondo claro para las "cards" */
            padding: 10px; /* Espacio interno para las "cards" */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra sutil para elevar visualmente */
        }

        table.dataTable tbody th, table.dataTable tbody td {
            width: 99%;
            padding: 8px 0px;
        }

        table.dataTable.no-footer {
            border-bottom: none;
        }

        .table-pt td {
            text-align: right;
            border: none;
            position: relative;
        }

        .table-pt td::before {
            content: attr(data-pt-label);
            position: absolute;
            left: 0;
            width: 50%;
            padding-left: 5px;
            font-weight: bold;
            text-align: left;
        }
    }
</style>

<section class="container">
    <div class="card hidden-content-patients">
        <div class="card-body">
            <ul class="nav nav-tabs" id="patientTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="active-patients-tab" data-bs-toggle="tab" data-bs-target="#active-patients" type="button" role="tab" aria-controls="active-patients" aria-selected="true">Pacientes Activos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inactive-patients-tab" data-bs-toggle="tab" data-bs-target="#inactive-patients" type="button" role="tab" aria-controls="inactive-patients" aria-selected="false">Pacientes Inactivos</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="no-account-patients-tab" data-bs-toggle="tab" data-bs-target="#no-account-patients" type="button" role="tab" aria-controls="no-account-patients" aria-selected="false">Pacientes Sin Cuenta</button>
                </li>
            </ul>
            <div class="tab-content" id="patientTabsContent">
                <!-- Tab for Active Patients -->
                <div class="tab-pane fade show active" id="active-patients" role="tabpanel" aria-labelledby="active-patients-tab">
                    <div class="table-responsive">
                        <table class="table-pt" id="activePatientsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Prestación</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($activePatients as $patient)
                                <tr id="patient-row-{{ $patient->idPaciente }}">
                                    <td data-pt-label="ID">{{ $patient->idPaciente ?? '-' }}</td>
                                    <td data-pt-label="Nombre">{{ $patient->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Apellido">{{ $patient->Apellido ?? '-' }}</td>
                                    <td data-pt-label="Prestación" class="patient-social-work">{{ $patient->socialWork->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Teléfono">{{ $patient->Telefono ?? '-' }}</td>
                                    <td data-pt-label="Acciones">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-patient-{{ $patient->idPaciente }}">Ver</button>
                                        <button class="btn btn-danger disable-btn-patient" data-paciente-id="{{ $patient->idPaciente }}" data-url="{{ route('patient.deactivate') }}">Deshabilitar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tab for Inactive Patients -->
                <div class="tab-pane fade" id="inactive-patients" role="tabpanel" aria-labelledby="inactive-patients-tab">
                    <div class="table-responsive">
                        <table class="table-pt" id="inactivePatientsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Prestación</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inactivePatients as $patient)
                                <tr id="patient-row-{{ $patient->idPaciente }}">
                                    <td data-pt-label="ID">{{ $patient->idPaciente ?? '-' }}</td>
                                    <td data-pt-label="Nombre">{{ $patient->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Apellido">{{ $patient->Apellido ?? '-' }}</td>
                                    <td data-pt-label="Prestación" class="patient-social-work">{{ $patient->socialWork->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Teléfono">{{ $patient->Telefono ?? '-' }}</td>
                                    <td data-pt-label="Acciones">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-patient-{{ $patient->idPaciente }}">Ver</button>
                                        <button class="btn btn-success enable-btn-patient" data-paciente-id="{{ $patient->idPaciente }}" data-url="{{ route('patient.activate') }}">Habilitar</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tab for Patients Without Account -->
                <div class="tab-pane fade" id="no-account-patients" role="tabpanel" aria-labelledby="no-account-patients-tab">
                    <div class="table-responsive">
                        <table class="table-pt" id="noAccountPatientsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Prestación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($noAccountPatients as $patient)
                                <tr id="patient-row-{{ $patient->idPaciente }}">
                                    <td data-pt-label="ID">{{ $patient->idPaciente ?? '-' }}</td>
                                    <td data-pt-label="Nombre">{{ $patient->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Apellido">{{ $patient->Apellido ?? '-' }}</td>
                                    <td data-pt-label="DNI">{{ $patient->DNI ?? '-' }}</td>
                                    <td data-pt-label="Prestación" class="patient-social-work">{{ $patient->socialWork->Nombre ?? '-' }}</td>
                                    <td data-pt-label="Acciones">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-patient-{{ $patient->idPaciente }}">Ver</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@foreach ($patients as $patient)
<!-- Modal for Patient Details -->
<div class="modal fade patients-modal" id="modal-patient-{{ $patient->idPaciente }}" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientModalLabel">Detalles del Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <strong>ID:</strong> {{ $patient->idPaciente ?? '-' }}
                            </div>
                            <div class="card-body">
                                <p><strong>Nombre:</strong> {{ $patient->Nombre ?? '-' }}</p>
                                <p><strong>Apellido:</strong> {{ $patient->Apellido ?? '-' }}</p>
                                <p><strong>Email:</strong> {{ $patient->user->Email ?? '-' }}</p>
                                <p><strong>Teléfono:</strong> {{ $patient->Telefono ?? '-' }}</p>
                                <p><strong>Dirección:</strong> {{ $patient->Domicilio ?? '-' }}</p>
                                <p><strong>Fecha de Nacimiento:</strong> {{ $patient->Fecha_Nacimiento ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-light">
                                <strong>Prestación:</strong> 
                                <span id="prestacion-{{ $patient->idPaciente }}">{{ $patient->socialwork->Nombre ?? '-' }}</span>
                            </div>
                            <div class="card-body">
                                <p><strong>Matricula:</strong> <span id="matricula-{{ $patient->idPaciente }}">{{ $patient->matriculaObraSocial && trim($patient->matriculaObraSocial) !== '' ? $patient->matriculaObraSocial : '-' }}</span></p>
                                <div class="mb-3">
                                    <label for="socialWorkSelect-{{ $patient->idPaciente }}">Obra Social:</label>
                                    <select id="socialWorkSelect-{{ $patient->idPaciente }}" class="form-select socialWorkSelect" name="social_work" data-paciente-id="{{ $patient->idPaciente }}">
                                        @if ($patient->socialWork)
                                            <option disabled value="0">Seleccione una obra social</option>
                                        @else
                                            <option disabled selected value="0">Seleccione una obra social</option>
                                        @endif
                                        @foreach ($socialWorks as $socialWork)
                                            <option value="{{ $socialWork->idObraSocial }}" 
                                                @if ($patient->socialWork && $patient->socialWork->idObraSocial == $socialWork->idObraSocial) 
                                                    selected 
                                                @endif>
                                                {{ $socialWork->Nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Contenedor para la matrícula -->
                                <div id="matriculaDiv-{{ $patient->idPaciente }}" style="display:none;">
                                    <label for="matriculaInput-{{ $patient->idPaciente }}">Matrícula:</label>
                                    <input type="text" id="matriculaInput-{{ $patient->idPaciente }}" class="form-control" name="matricula">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary save-btn" data-paciente-id="{{ $patient->idPaciente }}" style="display: none;">Guardar</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    $(document).ready(function() {
        function initializeDataTable(tableId) {
            $(tableId).DataTable({
                "paging": true,
                "pageLength": 5,
                "lengthChange": false,
                "searching": true,
                "order": [[0, 'desc']],
                "language": {
                    "sEmptyTable": "No hay datos disponibles en la tabla",
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Mostrar _MENU_ entradas",
                    "sLoadingRecords": "Cargando...",
                    "sProcessing": "Procesando...",
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No se encontraron resultados",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": activar para ordenar la columna de manera descendente"
                    }
                }
            });
            
            $('.hidden-content-patients').removeClass('hidden-content-patients');

        }
        
        initializeDataTable('#activePatientsTable');
        initializeDataTable('#inactivePatientsTable');
        initializeDataTable('#noAccountPatientsTable');

        $('.socialWorkSelect').change(function() {
            var pacienteId = $(this).data('paciente-id');
            var socialWorkId = $(this).val();
            var matriculaDiv = $('#matriculaDiv-' + pacienteId);
            var saveBtn = $('.save-btn[data-paciente-id="' + pacienteId + '"]');

            // console.log('Paciente ID:', pacienteId);
            // console.log('New Social Work ID:', socialWorkId);

            if (socialWorkId && socialWorkId != 1) {
                matriculaDiv.show(); // Mostrar el contenedor de matrícula si la obra social no es "Sin obra social"
                saveBtn.show(); // Mostrar el botón de guardar
            } else {
                matriculaDiv.hide(); // Ocultar el contenedor de matrícula si la obra social es "Sin obra social"
                saveBtn.hide(); // Ocultar el botón de guardar
                saveChanges(pacienteId, socialWorkId, ''); // Guardar sin matrícula
            }

            // Borrar la entrada de matricula cuando se selecciona una nueva obra social
            $('#matriculaInput-' + pacienteId).val('');
        });

        $('.save-btn').click(function() {
            var pacienteId = $(this).data('paciente-id');
            var socialWorkId = $('#socialWorkSelect-' + pacienteId).val();
            var matricula = $('#matriculaInput-' + pacienteId).val();

            // Validar si la matrícula está vacía
            if (socialWorkId != 1 && matricula.trim() === '') {
                alert('Por favor, ingrese una matrícula.');
                return;
            }

            saveChanges(pacienteId, socialWorkId, matricula);
        });

        function saveChanges(pacienteId, socialWorkId, matricula) {
            if (socialWorkId == 1) {
                matricula = '-'; // Establecer guion si la obra social es "Sin obra social"
            }
            
            $.ajax({
                url: '{{ route('patient.updateSocialWork') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    idPaciente: pacienteId,
                    idObraSocial: socialWorkId,
                    matricula: matricula
                },
                success: function(response) {
                    // console.log('Response:', response);
                    if (response.success) {
                        alert('Obra social y matrícula actualizadas con éxito');

                        // Actualizar la prestación y la matrícula en el modal de detalles del paciente
                        $('#modal-patient-' + pacienteId).find("#prestacion-" + pacienteId).html(response.socialWorkName);
                        $('#modal-patient-' + pacienteId).find("#matricula-" + pacienteId).html(response.matricula);

                        // Actualizar la prestación en el datatable
                        var row = $(`.table-pt tr:has(button[data-bs-target='#modal-patient-${pacienteId}'])`);
                        row.find("td[data-pt-label='Prestación']").html(response.socialWorkName);

                        // Limpiar y ocultar el campo de matrícula después de guardar
                        $('#matriculaInput-' + pacienteId).val('');
                        $('#matriculaDiv-' + pacienteId).hide();

                        $('#socialWorkSelect-' + pacienteId).val(socialWorkId);
                        $('.save-btn[data-paciente-id="' + pacienteId + '"]').hide();
                    } else {
                        alert('Error al actualizar la obra social y matrícula');
                    }
                }
            });
        }
    });
</script>

<!-- Main Js -->
<script src="{{ asset('assets/js/patient/patient-main.js') }}"></script>    