<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pacientes y su Historia Clínica</title>
    <style>
        .hidden-content {
            display: none;
        }

        .table-mh {
            text-align: center;
        }

        /* Estilos para pantallas pequeñas */
        @media (max-width: 768px) {
            .table-mh thead {
                display: none; /* Ocultar encabezado en móviles */
            }

            .table-mh, .table-mh tbody, .table-mh tr, .table-mh td {
                display: block;
                width: 100%;
                padding: 0px;
            }

            .table-mh tr {
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

            .table-group-divider {
                border-top: none;
            }

            table.dataTable.no-footer {
                border-bottom: none;
            }

            .table-mh td {
                text-align: right;
                border: none;
                position: relative;
            }
            
            .table-mh td::before {
                content: attr(data-mh-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 5px;
                font-weight: bold;
                text-align: left;
            }
        }

        /* Modal */
        @media (max-width: 768px) {
            #table-mh-modal thead {
                display: none; /* Ocultar encabezado en móviles */
            }

            #table-mh-modal, #table-mh-modal tbody, #table-mh-modal tr, #table-mh-modal td {
                display: block;
                width: 100%;
                padding: 0px;
            }

            #table-mh-modal tr {
                margin-top: 0.5rem;
                margin-bottom: 1rem;
                border: 1px solid #ddd; /* Borde alrededor de cada "card" */
                border-radius: 5px; /* Esquinas redondeadas */
                background-color: #f9f9f9; /* Fondo claro para las "cards" */
                padding: 10px; /* Espacio interno para las "cards" */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra sutil para elevar visualmente */
            }

            #table-mh-modal td {
                display: flex;
                align-items: center;
                border: none;
                padding: 8px 0px;
                position: relative;
                text-align: right;
            }

            .input-state {
                width: 50%;
            }
            
            #table-mh-modal td::before {
                content: attr(data-mh-modal);
                display: inline-block;
                width: 50%;
                padding-left: 5px;
                font-weight: bold;
                text-align: left;
                box-sizing: border-box;
            }

            #table-mh-modal .content {
                width: 50%;
                box-sizing: border-box;
                padding-left: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="p-t-120 p-b-100 font-poppins hidden-content">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Registro de Pacientes y su Historia Clínica</h2>
                    <div class="table-responsive-mh">
                        <table class="table-mh" id="tabla">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>DNI</th>
                                    <th>Historial Clinico</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider sm-1">
                                @foreach ($patientsWithMedicalHistory as $patient)
                                    @foreach ($patient->medicalHistory as $history)
                                    <tr>
                                        <td data-mh-label="Fecha">{{ $history->Fecha }}</td>
                                        <td data-mh-label="Paciente">{{ $patient->Nombre }} {{ $patient->Apellido }}</td>
                                        <td data-mh-label="DNI">{{ $patient->DNI }}</td>
                                        <td data-mh-label="Historial Clinico">
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $patient->idPaciente }}">
                                                <i class="fa-regular fa-file-lines"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row text-center"></div>
            </div>
        </div>
    </div>

    @foreach ($patientsWithMedicalHistory as $patient)
    <!-- Modal -->
    <div class="modal fade history-modal" id="exampleModal{{ $patient->idPaciente }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Historia Clínica de {{ $patient->Nombre }} {{ $patient->Apellido }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('actualizar-estado-historial') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <table class="table medicalHistory" id="table-mh-modal">
                            <thead>
                                <tr>
                                    <th>Diagnóstico</th>
                                    <th>Tratamiento</th>
                                    <th>Medicamento</th>
                                    <th>Fecha</th>
                                    <th>Estado de Tratamiento</th>
                                    <th>Receta Médica</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->medicalHistory as $historial)
                                <tr>
                                    <td data-mh-modal="Diagnostico">
                                        <div class="content">{{ $historial->Diagnostico }}</div>
                                    </td>
                                    <td data-mh-modal="Tratamiento">
                                        <div class="content">{{ $historial->Tratamiento }}</div>
                                    </td>
                                    <td data-mh-modal="Medicamento">
                                        <div class="content">{{ $historial->Medicamento }}</div>
                                    </td>
                                    <td data-mh-modal="Fecha">
                                        <div class="content">{{ $historial->Fecha }}</div>
                                    </td>
                                    <td data-mh-modal="Estado">
                                        <div class="input-state">
                                            <select class="form-control estado-tratamiento" name="estado_tratamiento" data-historial-id="{{ $historial->idHistorial }}">
                                                @foreach($estadosHistoriales as $estado)
                                                <option value="{{ $estado->idEstado_Historial }}" @if($historial->Historiales_idEstado_Historial == $estado->idEstado_Historial) selected @endif>
                                                    {{ $estado->Desc_Historial }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td data-mh-modal="Receta">
                                        <div class="content">
                                            <a href="{{ route('medicalhistory-pdf', ['id' => $historial->idHistorial]) }}" target="_blank" class="btn btn-danger">
                                                <i class="fa-regular fa-file-lines"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        $(document).ready(function () {
            cargarDatos();

            function cargarDatos() {
                $('#tabla').DataTable({
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
                $('.hidden-content').removeClass('hidden-content');
            }

            $('.estado-tratamiento').change(function () {
                var historialId = $(this).data('historial-id');
                var estadoTratamiento = $(this).val();

                $.ajax({
                    url: '{{ route('actualizar-estado-historial') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        historial_id: historialId,
                        estado_tratamiento: estadoTratamiento
                    },
                    success: function (response) {
                        if (response.success) {
                            alert('Estado del tratamiento actualizado exitosamente');
                        } else {
                            alert('Error al actualizar el estado del tratamiento');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>