<style>
    /* Limita la altura máxima de los textarea */
    textarea.form-control {
        max-height: 150px;  
        min-height: 50px;
    }
</style>

<body>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Por las chancas de mi madre!</strong> Algo salió mal..<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-t-120 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title"> Registro de Consulta Médica</h2>
                    <form id="medicalConsultationForm">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <label class="form-label">Paciente</label>
                                <div class="input-group">
                                    <select id="paciente" class="form-select" name="paciente">
                                        <option selected disabled value="">Buscar...</option>
                                        @foreach ($pacientes as $paciente)
                                            <option value="{{$paciente->idPaciente}}">{{$paciente->Nombre}} {{ $paciente->Apellido }} - {{$paciente->idPaciente}}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append" style="margin-left: 10px;">
                                        <button type="button" class="btn btn-primary" style="padding: 0.2rem 0.75rem; font-size: 0.875rem; border-radius: 20px;" data-bs-toggle="modal" data-bs-target="#nuevoPacienteModal">
                                            <i class="far fa-user"></i> +
                                        </button>
                                    </div>
                                </div>

                                <div class="row" id="patientDetails" style="display: none;">
                                    <div class="form-group col-md-6">
                                        <label class="form-label mt-4">Obra Social</label>
                                        <select id="obra_social" class="form-select" name="obra_social">
                                            <option selected disabled value="">Seleccionar obra social...</option>
                                            @foreach ($socialWorks as $obra_social)
                                                <option value="{{$obra_social->idObraSocial}}">{{$obra_social->Nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label mt-4">Matrícula</label>
                                        <input type="text" class="form-control" name="matricula" id="matricula" placeholder="Ingresar matrícula" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label mt-4">Diagnóstico</label>
                                        <textarea class="form-control" name="Diagnostico" placeholder="Ingresar diagnóstico" type="text" rows="9"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label mt-4">Tratamiento</label>
                                        <textarea class="form-control" name="Tratamiento" placeholder="Ingresar tratamiento" type="text" rows="9"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label mt-4">Medicamento</label>
                                        <textarea class="form-control" name="Medicamento" placeholder="Ingresar medicamento" type="text" rows="9"></textarea>
                                    </div>
                                </div>

                                <div class="col-9 mt-6"> 
                                    <button type="submit" class="btn btn-secondary">Registrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="nuevoPacienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Paciente</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoPacienteModal" action="{{ route('newPatient') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese el apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI:</label>
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese el DNI" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>   
    
    <script>
        $(document).ready(function() {
    // Inicialización de Select2
    $('#paciente').select2({
        placeholder: "Buscar...",
        allowClear: true,
        language: {
            errorLoading: function() {
                return "No se pudo cargar los resultados";
            },
            inputTooLong: function(args) {
                var overChars = args.input.length - args.maximum;
                var message = "Por favor, elimine " + overChars + " car";
                if (overChars == 1) {
                    message += "ácter";
                } else {
                    message += "acteres";
                }
                return message;
            },
            inputTooShort: function(args) {
                var remainingChars = args.minimum - args.input.length;
                return "Por favor, introduzca " + remainingChars + " car" + (remainingChars == 1 ? "ácter" : "acteres");
            },
            loadingMore: function() {
                return "Cargando más resultados…";
            },
            maximumSelected: function(args) {
                var message = "Sólo puede seleccionar " + args.maximum + " elemento";
                if (args.maximum != 1) {
                    message += "s";
                }
                return message;
            },
            noResults: function() {
                return "No se encontraron resultados";
            },
            searching: function() {
                return "Buscando…";
            },
            removeAllItems: function() {
                return "Eliminar todos los elementos";
            }
        }
    });

     // Mostrar y actualizar los detalles del paciente
     $('#paciente').on('change', function() {
        var selectedPatientId = $(this).val();
        if (selectedPatientId) {
            $.ajax({
                url: '/getPatientDetails/' + selectedPatientId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Guarda la matrícula del paciente y actualiza el formulario
                        patientMatricula = response.patient.matricula;
                        $('#obra_social').val(response.patient.idObraSocial).trigger('change');
                        $('#matricula').val(patientMatricula || '');
                        $('#patientDetails').show();
                    } else {
                        alert('Error al obtener los detalles del paciente: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX');
                }
            });
        } else {
            $('#patientDetails').hide();
        }
    });

    // Manejo del cambio de obra social
    $('#obra_social').on('change', function() {
        var selectedObraSocialId = $(this).val();

        if (selectedObraSocialId) {
            // Verifica si la obra social seleccionada coincide con la del paciente actual
            var currentPatientObraSocialId = $('#paciente').val();
            
            if (currentPatientObraSocialId) {
                $.ajax({
                    url: '/getPatientDetails/' + currentPatientObraSocialId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (response.patient.idObraSocial == selectedObraSocialId) {
                                // Si la obra social seleccionada es la misma, muestra la matrícula
                                $('#matricula').val(patientMatricula || '');
                            } else {
                                // Si la obra social es diferente, vacía la matrícula
                                $('#matricula').val('');
                            }
                        } else {
                            alert('Error al obtener los detalles del paciente: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error en la solicitud AJAX');
                    }
                });
            }
        } else {
            $('#matricula').val('');
        }
    });

    // Manejo del formulario de consulta médica
    $('#medicalConsultationForm').on('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe normalmente

        var actionUrl = '{{ route('record') }}';
        var method = 'POST';
        var formData = $(this).serialize();

        // Envía la petición AJAX para registrar la consulta médica
        $.ajax({
            url: actionUrl,
            method: method,
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Muestra un mensaje de éxito
                    alert('¡Consulta médica registrada con éxito!');
                    $('#medicalConsultationForm')[0].reset(); // Reinicia el formulario
                    $('#paciente').val(null).trigger('change'); // Resetea el select2
                    $('#patientDetails').hide();
                } else {
                    alert('Error al registrar la consulta médica: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
            }
        });
    });

    // Manejo del formulario de nuevo paciente en el modal
    $('#formNuevoPacienteModal').on('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe normalmente

        var actionUrl = $(this).attr('action');
        var method = $(this).attr('method');
        var formData = $(this).serialize();

        // Envía la petición AJAX para crear un nuevo paciente
        $.ajax({
            url: actionUrl,
            method: method,
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var $selectPaciente = $('#paciente');
                    var newOption = new Option(response.patient.Nombre + ' ' + response.patient.Apellido + ' - ' + response.patient.idPaciente, response.patient.idPaciente, true, true);
                    $selectPaciente.append(newOption).trigger('change'); // Agrega la opción y actualiza Select2
                    alert('¡Paciente creado correctamente!');
                    // Resetear el formulario
                    $('#formNuevoPacienteModal')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
            }
        });
    });
});
    </script>
</body>
</html>