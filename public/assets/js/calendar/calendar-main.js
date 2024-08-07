var selectedPatient;
var blockedHours = [];

$(document).ready(function () {
  initEventListeners();
});

function initEventListeners() {
  selectPatient();
  blockDayButton();
  blockTimetables();
  unlockDayButton();
  saveNewHours();
}

function cargarTurnos(dateClicked) {
    // console.log(dateClicked);
    $('#btnGuardarHoras').hide();
    $.ajax({
        url: routes.getTimetables,
        data: { date: dateClicked },
        type: "POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          resetSelectPatient();
          cargarTablaTurnos(data.availableSlots);
          $("#modalCalendar").show();
          if (data.message) {
            alert(data.message);
          }        
        }
    });
}

function cargarTablaTurnos(data) {
  $('#tablaTurnosPacientesCalendar tbody tr').remove();

  var intervalForm = document.getElementById('intervalForm');
  if (intervalForm) {
    intervalForm.reset();
  }

  let filas = '';
  for (let i = 0; i < data.length; i++) {
      let idTurno = data[i].idTurno;
      let turno = data[i].Franja_Horaria;
      let fecha = data[i].Fecha;
      let horario = data[i].Hora;
      let disponibilidad = data[i].Disponibilidad;
      let idPatient = data[i].idPaciente;
      let patient = data[i].Paciente;
      let estado = data[i].Estado;
      let blocked = data[i].isBlocked;

      let claseEstado = blocked ? 'blocked' : idPatient === null ? 'disponible' : idPatient === patientId ? 'turno-usuario' : disponibilidad === 'No disponible' ? 'no-disponible' : '';

      if (professionalId) {
          filas += `
          <tr class="${claseEstado}">
            <td class="${claseEstado}" data-label="Turno" data-turno-id="${idTurno}">${turno}</td>
            <td class="${claseEstado}" data-label="Fecha y Hora">${fecha} | ${horario}</td>
            <td class="${claseEstado}" data-label="Disponibilidad">${disponibilidad}</td>
            <td class="${claseEstado}" data-label="Paciente">${patient}</td>
            <td class="${claseEstado}" data-label="Estado">${estado}</td>
          </tr>`;
      } else {
          filas += `
          <tr class="${claseEstado}">
            <td class="${claseEstado}" data-label="Turno" data-turno-id="${idTurno}">${turno}</td>
            <td class="${claseEstado}" data-label="Fecha y Hora">${fecha} | ${horario}</td>
            <td class="${claseEstado}" data-label="Disponibilidad" style="display:none;">${disponibilidad}</td>
          </tr>`;
      }
  }
  $('#tablaTurnosPacientesCalendar tbody').append(filas);
  tomarDatos();
}

function selectPatient() {
  $('.selectPacienteCalendar').on('change', function() {
    selectedPatient = $(this).val();
    // console.log('select:' + selectedPatient);
  });
}

function resetSelectPatient() {
  $('#selectPacienteCalendar').val(null).trigger('change'); // Resetea el select2
  selectedPatient = null; // Reinicia la variable global

  // Forzar el texto visible en el placeholder y eliminar el botón "clear"
  $('.select2-selection__rendered').html('<span class="select2-selection__placeholder">Pacientes...</span>');
  $('.select2-selection__clear').remove(); // Eliminar el botón "clear"

  $('#selectPacienteCalendar').prop('disabled', false);
}

function tomarDatos(){
    let btnBlockXhora = false;

    $('#btnBloquearXhora').on('click', function () {
      btnBlockXhora = !btnBlockXhora;

      // console.log("btn bloquear por hora: "+btnBlockXhora);

      if (btnBlockXhora) {
        $('#selectPacienteCalendar').prop('disabled', true); // Habilitado (oculta select)
        $('#btnGuardarHoras').show();
      } else {
        $('#selectPacienteCalendar').prop('disabled', false); // Desabilitado (muestra select)
        $('#btnGuardarHoras').hide();
        $('#tablaTurnosPacientesCalendar tbody tr.seleccionado').removeClass('seleccionado');
        blockedHours = [];
      }
    });

    $('#tablaTurnosPacientesCalendar tbody').off('click').on('click', 'tr', function() { 
      if (btnBlockXhora) {
        // Obtener el estado de la fila seleccionada
        var estado = $(this).find('td:eq(2)').text(); 

        // Si el estado es 'No disponible', mostrar alerta y no permitir seleccionar la fila
        if (estado === 'No disponible') {
          alert('No se puede bloquear este horario, ya que es un turno asignado.');
          return;
        }

        $(this).toggleClass('seleccionado');

        // Obtener los datos de la fila seleccionada
        var fechaHora = $(this).find('td:eq(1)').text(); // Obtener la fecha y hora de la primera celda

        var partes = fechaHora.split(' | '); // Suponiendo que el espacio en blanco es el separador

        var Fecha = partes[0]; // Obtener la parte de la cadena correspondiente a la fecha
        var Hora = partes[1]; // Obtener la parte de la cadena correspondiente a la hora
        
        // Verificar si la fecha y hora ya existen en el array blockedHours. Si devuelve -1, no existe el elemento
        const index = blockedHours.findIndex(item => item.Fecha === Fecha && item.Hora === Hora);

        if (index === -1) {
          blockedHours.push({ Fecha, Hora });
        } else if (index !== -1) {
          blockedHours.splice(index, 1);
        }
        
        // console.log(blockedHours); 
        
      } else {
        // Obtener los datos de la fila seleccionada
        var fechaHora = $(this).find('td:eq(1)').text(); // Obtener la fecha y hora de la primera celda
        var estado = $(this).find('td:eq(2)').text(); // Obtener el estado de la segunda celda

        var partes = fechaHora.split(' | '); // Suponiendo que el espacio en blanco es el separador

        var Fecha = partes[0]; // Obtener la parte de la cadena correspondiente a la fecha
        var Hora = partes[1]; // Obtener la parte de la cadena correspondiente a la hora
        
        var turnoId = $(this).find('td:first').attr('data-turno-id'); 

        if (estado === 'Disponible') {
          if (btnBlockXhora == false && professionalId && (selectedPatient === null || selectedPatient === '')) {
            alert('Por favor, seleccione un paciente.');
            return;
          } else if (btnBlockXhora == false && professionalId && (selectedPatient != null || selectedPatient != '')) {
            if (confirm('¿Desea reservar este turno?')) {
              guardarTurno(Fecha, Hora, selectedPatient);
            }
          } else if (patientId) {
            if (confirm('¿Desea reservar este turno?')) {
              guardarTurno(Fecha, Hora, selectedPatient);
            }
          }  
        } else if (estado === 'No disponible' && $(this).hasClass('turno-usuario')) {
          if (confirm('¿Está seguro de que desea cancelar este turno?')) {
            cancelarTurnos(turnoId);
          }
        } else if (professionalId && estado === 'No disponible') {
          if (confirm('¿Está seguro de que desea cancelar este turno?')) {
            cancelarTurnos(turnoId);
          }
        } else if (estado === 'No disponible') {          
          alert('Turno no disponible');    
        } 
      }
  });
}

function blockDayButton() {
  $('#btnBloquearDia').on('click', function () {
    let filas = document.querySelectorAll('#tablaTurnosPacientesCalendar tbody tr');
    let allBlockedHours = [];
    let hasReservedTurns = false;

    filas.forEach(function(fila) {
      let estado = fila.querySelector('td:nth-child(3)').textContent;

      // Verificar si el estado es 'No disponible'
      if (estado !== 'No disponible') {
        let fechaHora = fila.querySelector('td:nth-child(2)').textContent;
        let partes = fechaHora.split(' | ');

        let Fecha = partes[0];
        let Hora = partes[1];

        allBlockedHours.push({ Fecha, Hora });
      } else if (estado === 'No disponible') {
        hasReservedTurns = true;
      }
    });

    blockedHours = allBlockedHours;

    if (hasReservedTurns) {
      // Mostrar mensaje de confirmación si hay turnos reservados
      if (confirm('¿Estás seguro de que quieres bloquear el día? Existen turnos asignados.')) {
        bloquearXhora(blockedHours);
      }
    } else {
      // Bloquear directamente si no hay turnos reservados
      bloquearXhora(blockedHours);
    }

    allBlockedHours.length = 0;
  });
}

function blockTimetables() {
  $('#btnGuardarHoras').on('click', function () {
    if (blockedHours.length > 0) {
      bloquearXhora(blockedHours);
      $('#btnGuardarHoras').hide();
    } else {
      alert('No hay turnos seleccionados para guardar.');
    }
  });
}

function unlockDayButton() {
  $('#btnDesbloquearDia').on('click', function () {
    if (dateClicked) {
      desbloquearDias(dateClicked); 
    } 
  });
}

function guardarTurno(Fecha, Hora, selectedPatient) {
    // Desactivar interacción con la tabla mientras se procesa la solicitud AJAX
    $('#tablaTurnosPacientesCalendar').addClass('disabled-table');
    $('.buttonOptions-container button').addClass('disabled-buttons');
    $('.intervalMinute').addClass('disabled-buttons');

    var formData = new FormData();    
    formData.append('Fecha', Fecha); 
    formData.append('Hora', Hora);

    if (patientId) {
      formData.append('Pacientes_idPaciente', patientId);
    } else {
      formData.append('Pacientes_idPaciente', selectedPatient);
    }
    
    $.ajax({
      url: routes.guardarTurnos,
      data: formData,
      type: 'POST',
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        alert('Operación exitosa');
        cargarTurnos(dateClicked);
        resetSelectPatient();
      },
      error: function (xhr, status, error) {
        // Manejar errores
        var errorMessage = xhr.responseJSON.error;
        alert(errorMessage);
      },
      complete: function () {
        // Reactivar interacción con la tabla después de completar la solicitud AJAX
        $('#tablaTurnosPacientesCalendar').removeClass('disabled-table');
        $('.buttonOptions-container button').removeClass('disabled-buttons');
        $('.intervalMinute').removeClass('disabled-buttons');
      }
    });
}

function cancelarTurnos(turnoId) {
  // Desactivar interacción con la tabla mientras se procesa la solicitud AJAX
  $('#tablaTurnosPacientesCalendar').addClass('disabled-table');
  $('.buttonOptions-container button').addClass('disabled-buttons');
  $('.intervalMinute').addClass('disabled-buttons');

  $.ajax({
      url: routes.cancelarTurnos,
      method: 'POST',
      data: { 
        turnoId: turnoId,
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        alert(response.message); // Muestra un mensaje de éxito o error
        cargarTurnos(dateClicked);
        resetSelectPatient();
      },
      error: function(xhr, status, error) {
        // Manejar errores de la solicitud
        // console.error(error);
        alert('Se produjo un error al cancelar el turno');
      },
      complete: function () {
        // Reactivar interacción con la tabla después de completar la solicitud AJAX
        $('#tablaTurnosPacientesCalendar').removeClass('disabled-table');
        $('.buttonOptions-container button').removeClass('disabled-buttons');
        $('.intervalMinute').removeClass('disabled-buttons');
      }
  });
}

function desbloquearDias(dateClicked) {
  $.ajax({
    url: routes.desbloquearTurnos,
    method: 'POST',
    data: {
      Fecha: dateClicked,
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      alert(response.message);
      cargarTurnos(dateClicked);
      resetSelectPatient();
    },
    error: function (xhr, status, error) {
      // Manejar errores de la solicitud
      // console.error(error);
      alert('Se produjo un error al desbloquear el día');
    }
  });
}

function bloquearXhora(blockedHours) {
  $.ajax({
    url: routes.bloquearxhora,
    data: JSON.stringify(blockedHours),
    type: 'POST',
    contentType: 'application/json',
    processData: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      alert(response.message);
      cargarTurnos(dateClicked);
      blockedHours.length = 0;
      $('#tablaTurnosPacientesCalendar tbody tr.seleccionado').removeClass('seleccionado');
      resetSelectPatient();
    },
    error: function (xhr, status, error) {
      var errorMessage = xhr.responseJSON.error;
      alert(errorMessage);
    }
  });
}

function saveNewHours() {
  $('#intervalForm').on('submit', function (e) {
    e.preventDefault();
    handleIntervalFormSubmit(dateClicked);
  });
}

function handleIntervalFormSubmit(dateClicked) {
  var interval = $('#interval').val();
  var morningStart = $('#morningStart').val();
  var morningEnd = $('#morningEnd').val();
  var afternoonStart = $('#afternoonStart').val();
  var afternoonEnd = $('#afternoonEnd').val();

  // Obtener las fechas de los días seleccionados
  var selectedDates = [];
  $('.weekdays-container input[type="checkbox"]:checked').each(function () {
    var date = $(this).next('span').text(); // Obtener la fecha del span siguiente al checkbox
    selectedDates.push(date); // Agregar la fecha al array de fechas seleccionadas
  });

  // Verificar si no hay días seleccionados
  if (selectedDates.length === 0) {
    alert('No hay días seleccionados. Por favor, selecciona al menos un día.');
    return;
  }

  $.ajax({
    url: routes.guardarHorarios,
    method: 'POST',
    data: {
      interval: interval,
      morningStart: morningStart,
      morningEnd: morningEnd,
      afternoonStart: afternoonStart,
      afternoonEnd: afternoonEnd,
      date: dateClicked,
      selectedDays: selectedDates 
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (response) {
      $('#intervalModal').hide();
      document.getElementById('intervalForm').reset();
      alert(response.message);
      cargarTurnos(dateClicked);
      resetSelectPatient();
      selectedDates = [];
    },
    error: function (error) {
      alert('Error al actualizar los horarios: ' + error.responseJSON.error);
    }
  });
}