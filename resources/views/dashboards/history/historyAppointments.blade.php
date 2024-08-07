<style>
    .hidden-content-history {
        display: none;
    }
    /* Responsive styles for smaller screens */
    @media (max-width: 767px) {
        .table-ha thead {
            display: none;
        }

        .table-ha, .table-ha tbody, .table-ha tr, .table-ha td {
            display: block;
            width: 100%;
            padding: 0px;
        }

        .table-ha tr {
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

        .table-ha td {
            text-align: right;
            border: none;
            position: relative;
        }

        .table-ha td::before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 50%;
            padding-left: 5px;
            font-weight: bold;
            text-align: left;
        }
    }
</style>

<div class="container mt-4">
    <div class="table-responsive hidden-content-history">
        <table class="table-ha" id="appointmentHistoryTable">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Franja</th>
                    @if ($professional)
                        <th>Paciente</th>
                    @endif
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->Fecha }}</td>
                        <td>{{ $appointment->Hora }}</td>
                        <td>{{ $appointment->Franja_Horaria }}</td>
                        @if ($professional)
                            <td>{{ $appointment->Nombre }} {{ $appointment->Apellido }}</td>
                        @endif
                        <td>{{ $appointment->Estado_Turno }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#appointmentHistoryTable').DataTable({
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
        $('.hidden-content-history').removeClass('hidden-content-history');
    });
</script>