@extends('layouts.app')

@section('content')
<div class="container">
  <button id="btnAbrirModalCalendar" style="display: none;">Abrir Modal</button>
  <div id="modalCalendar" class="modalCalendar">
    <div class="modal-contentCalendar">
      <span class="close">&times;</span>
        @if ($professional)
        <div class="input-selectCalendar">
          <select id="selectPacienteCalendar" class="form-select selectPacienteCalendar">
            <option selected disabled value="">Seleccionar paciente</option>
            @foreach($listPatients as $patientOption)
              <option value="{{ $patientOption->idPaciente }}">{{ $patientOption->Nombre }} {{ $patientOption->Apellido }}</option>
            @endforeach
          </select>
        </div>
        <div class="buttonOptions-container">
          <button id="btnBloquearDia" class="btn btn-danger">Bloquear Día</button>
          <button id="btnDesbloquearDia" class="btn btn-primary">Desbloquear Día</button>
          <button id="btnBloquearXhora" class="btn btn-secondary">Bloquear Horario</button>
          <button id="btnGuardarHoras" class="btn btn-success">Guardar</button>
          <div class="intervalMinute">
            <span><i class="fa-regular fa-clock"></i> Modificar Atención</span>
          </div>
        </div>
        @endif
        @if ($professional)
        <table id="tablaTurnosPacientesCalendar" class="table table-bordered">
          <thead>
            <tr>
              <th>Turno</th>
              <th>Fecha y Hora</th>
              <th>Disponibilidad</th>
              <th>Paciente</th>
              <th>Estado</th>
            </tr>
          </thead>
          <tbody>  
            <!-- ... -->
          </tbody>
        </table>
        @elseif ($patient)
        <div class="reference-container">
          <div class="color-reference-appointment" style="background-color: white;"></div><div class="state">Disponible</div> 
          <div class="color-reference-appointment" style="background-color: #ffcccc;"></div><div class="state">Ocupado</div> 
          <div class="color-reference-appointment" style="background-color: #e0e0e0;"></div><div class="state">Asignado</div> 
        </div>
        <table id="tablaTurnosPacientesCalendar" class="table table-bordered">
          <thead>
            <tr>
              <th>Turno</th>
              <th>Fecha y Hora</th>
            </tr>
          </thead>
          <tbody>  
            <!-- ... -->
          </tbody>
        </table>
        @endif
    </div>
  </div>
</div>

@if ($professional)
<div id="intervalModal" style="display: none;">
  <div class="intervalModalContent">
    <span class="closeIntervalModal">&times;</span>
    <div class="containerForm">
      <h3>Horario de Atención</h3>
      <form id="intervalForm">
        <label for="interval">Intervalo de tiempo (en minutos):</label>
        <input type="number" id="interval" name="interval" min="10" max="60" step="5" required>

        <div class="weekdays-container">
          <label><input type="checkbox" value="1"> Lunes <span></span></label>
          <label><input type="checkbox" value="2"> Martes <span></span></label>
          <label><input type="checkbox" value="3"> Miércoles <span></span></label>
          <label><input type="checkbox" value="4"> Jueves <span></span></label>
          <label><input type="checkbox" value="5"> Viernes <span></span></label>
        </div>

        <div class="containerMorning">
          <h4>Mañana</h4>
          <label for="morningStart">Desde:</label>
          <input type="time" id="morningStart" name="morningStart" min="07:00" max="12:00" required>
          <label for="morningEnd">Hasta:</label>
          <input type="time" id="morningEnd" name="morningEnd" min="07:00" max="12:00" required>
        </div>
        
        <div class="containerAfternoon">
          <h4>Tarde</h4>
          <label for="afternoonStart">Desde:</label>
          <input type="time" id="afternoonStart" name="afternoonStart" min="13:00" max="19:00" required>
          <label for="afternoonEnd">Hasta:</label>
          <input type="time" id="afternoonEnd" name="afternoonEnd" min="13:00" max="19:00" required>
        </div>

        <div class="containerButton">
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
@endsection

<script>
  var patientId = {{ $patient ? $patient->idPaciente : 'null' }};
  var professionalId = {{ $professional ? $professional->idProfesional : 'null' }};
  var selectedPatient;
  
  var routes = {
    getTimetables: "{{ route('getTimetables') }}",
    guardarTurnos: "{{ route('guardarTurnos') }}",
    cancelarTurnos: "{{ route('cancelarTurnos') }}",
    bloquearTurnos: "{{ route('bloquearDia') }}",
    desbloquearTurnos: "{{ route('desbloquearDia') }}",
    bloquearxhora: "{{ route('bloquearxhora') }}",
    guardarHorarios: "{{ route('store') }}",
  };

  $(document).ready(function () {
    $('#selectPacienteCalendar').select2({
      placeholder: "Pacientes...",
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
    }).on('select2:open', function() {
      $('.select2-container').addClass('modal-select2');
    }).on('select2:close', function() {
      $('.select2-container').removeClass('modal-select2');
    });

    var today = new Date();
    today.setHours(0, 0, 0, 0); // A partir de la fecha actual
    
    var monthsLater = moment(today).add(7, 'months');  // Hasta 7 meses despues

    // Inicializar el calendario cuando el documento esté listo
    initializeCalendar();

    // Función para inicializar el calendario
    function initializeCalendar() {
      $('#calendarContent').fullCalendar({
        locale: 'es',
        header: {
          left: 'prev,next,today',
          center: 'title',
          right: 'month,basicWeek'
        },
        navLinks: true,
        editable: true,
        displayEventTime: false,
        validRange: {
          start: today,
          end: monthsLater
        },
        eventRender: function (event, element, view) {
          event.allDay = event.allDay === 'true';
        },
        dayClick: handleDayClick
      });
    }

    // Función para manejar el clic en un día del calendario
    function handleDayClick(date, jsEvent, view) {
      var dayOfWeek = date.day(); // Obtiene el día de la semana (0 para domingo, 1 para lunes, etc.)
      if (dayOfWeek === 0 || dayOfWeek === 6) { // Si es sábado (6) o domingo (0)
          alert('No se pueden reservar turnos los sábados y domingos.');
          return false; // Evitar la selección del día
      } else {
          var modal = document.getElementById("modalCalendar");
          dateClicked = date.format('YYYY-MM-DD'); // variable global
          cargarTurnos(dateClicked);

          // Obtener el botón que abre el modal
          var btn = document.getElementById("btnAbrirModalCalendar");

          // Obtener el elemento span que cierra el modal
          var span = document.getElementsByClassName("close")[0];

          // Cuando el usuario haga clic en el botón, abre el modal
          btn.onclick = function () {
            modal.style.display = "block";
          };

          // Cuando el usuario haga clic en el botón de cierre (x), cierra el modal
          span.onclick = function () {
            modal.style.display = "none";
            // console.log("cerrado");
          };
          
          // Ingresa como usuario professional
          if (professionalId) {
            handleIntervalModal(dayOfWeek);
          }

          // Cuando el usuario haga clic fuera del modal, ciérralo
          window.onclick = function (event) {
            if (event.target == modal) {
              modal.style.display = "none";
            } 
            // else if (event.target == intervalModal) {
            //   intervalModal.style.display = "none";
            // }
          }
      }
    }

    // Función para manejar el intervalo modal
    function handleIntervalModal(dayOfWeek) {
      var intervalModal = document.querySelector("#intervalModal");
      var btnCambiarIntervalo = document.querySelector(".intervalMinute");
      var spanInterval = document.querySelector(".closeIntervalModal");

      btnCambiarIntervalo.onclick = function () {
        intervalModal.style.display = "block";
        
        $('.weekdays-container input[type="checkbox"]').prop('checked', false);
        
        if (dayOfWeek) {
          // Marcar checkbox correspondiente al día de la semana
          $('.weekdays-container input[type="checkbox"][value="' + dayOfWeek + '"]').prop('checked', true);
        }

        // Calcular las fechas de lunes a viernes de la semana en la que se hizo clic
        var start = moment(dateClicked).startOf('week').add(1, 'day'); // Comienza desde el lunes de la semana seleccionada
        var end = moment(dateClicked).endOf('week').subtract(1, 'day'); // Termina al viernes de la semana seleccionada
        var dates = [];

        while (start.isSameOrBefore(end)) {
          dates.push(start.format('YYYY-MM-DD'));
          start.add(1, 'day');
        }

        // console.log('Fechas seleccionadas:', dates); // Mostrar fechas en la consola

        // Asignar las fechas a los checkboxes
        assignDatesToCheckboxes(dates);
      };

      spanInterval.onclick = function () {
        intervalModal.style.display = "none";
      };
    }

    // Función para asignar las fechas a los checkboxes
    function assignDatesToCheckboxes(dates) {
      $('.weekdays-container input[type="checkbox"]').each(function (index) {
        // Obtener el valor del checkbox (1 para lunes, 2 para martes, etc.)
        var dayOfWeek = $(this).val();

        // Obtener la fecha correspondiente del array de fechas
        var date = dates[dayOfWeek - 1]; // Restar 1 porque los días de la semana empiezan en 1

        // Verificar si la fecha es anterior o igual a today
        var isDatePastOrToday = moment(date).isBefore(today, 'day');

        // Establecer el valor del checkbox con la fecha correspondiente
        $(this).next('span').text(date); // Asigna el texto al elemento span siguiente al checkbox

        if (isDatePastOrToday) {
          $(this).prop('disabled', true); // Deshabilitar el checkbox
        } else {
          $(this).prop('disabled', false); // Habilitar el checkbox
        }
      });
    }
  });
</script>

<script src="{{ asset('assets/js/calendar/calendar-main.js') }}"></script>