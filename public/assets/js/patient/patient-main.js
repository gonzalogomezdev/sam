$(document).ready(function() {
    function deactivatePatient(id, row, dataUrl) {
        $(".enable-btn-patient, .disable-btn-patient").addClass('disabled').css('pointer-events', 'none');
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: { id: id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                alert('El paciente ha sido dado de baja!');
                moveRowToInactiveTable(row);
                checkIfTableIsEmpty();
            },
            error: function(error) {
                alert("Error al dar de baja al paciente.");
                $(".enable-btn-patient, .disable-btn-patient").removeClass('disabled').css('pointer-events', 'auto');
            },
            complete: function() {
                $(".enable-btn-patient, .disable-btn-patient").removeClass('disabled').css('pointer-events', 'auto');
            }
        });
    }

    function activatePatient(id, row, dataUrl) {
        $(".enable-btn-patient, .disable-btn-patient").addClass('disabled').css('pointer-events', 'none');
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: { id: id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                alert('El paciente ha sido dado de alta!');
                moveRowToActiveTable(row);
                checkIfTableIsEmpty();
            },
            error: function(error) {
                alert("Error al dar de alta al paciente.");
                $(".enable-btn-patient, .disable-btn-patient").removeClass('disabled').css('pointer-events', 'auto');
            },
            complete: function() {
                $(".enable-btn-patient, .disable-btn-patient").removeClass('disabled').css('pointer-events', 'auto');
            }
        });
    }

    function moveRowToInactiveTable(row) {
        var activeTable = $('#activePatientsTable').DataTable();
        var inactiveTable = $('#inactivePatientsTable').DataTable();

        // Copiar la fila sin eventos
        var newRow = $(row).clone(true, true);

        // Eliminar la fila de la tabla activa
        activeTable.row(row).remove().draw(false);

        // Modificar y agregar la nueva fila a la tabla inactiva
        newRow.find('.disable-btn-patient').remove();
        newRow.find('td:last').append('<button class="btn btn-success enable-btn-patient" data-paciente-id="' + newRow.find('td:first').text() + '" data-url="/patient/activate">Habilitar</button>');
        inactiveTable.row.add(newRow).draw(false);

        // Reasignar eventos para el nuevo botón
        reassignEventsAndClasses();
    }

    function moveRowToActiveTable(row) {
        var inactiveTable = $('#inactivePatientsTable').DataTable();
        var activeTable = $('#activePatientsTable').DataTable();

        // Copiar la fila sin eventos
        var newRow = $(row).clone(true, true);

        // Eliminar la fila de la tabla inactiva
        inactiveTable.row(row).remove().draw(false);

        // Modificar y agregar la nueva fila a la tabla activa
        newRow.find('.enable-btn-patient').remove();
        newRow.find('td:last').append('<button class="btn btn-danger disable-btn-patient" data-paciente-id="' + newRow.find('td:first').text() + '" data-url="/patient/deactivate">Deshabilitar</button>');
        activeTable.row.add(newRow).draw(false);

        // Reasignar eventos para el nuevo botón
        reassignEventsAndClasses();
    }

    function reassignEventsAndClasses() {
        $(document).off('click', '.enable-btn-patient').on('click', '.enable-btn-patient', function(e) {
            e.preventDefault();
            var patientId = $(this).data('paciente-id');
            var row = $(this).closest('tr');
            var dataUrl = $(this).data('url');
            activatePatient(patientId, row, dataUrl);
        });

        $(document).off('click', '.disable-btn-patient').on('click', '.disable-btn-patient', function(e) {
            e.preventDefault();
            var patientId = $(this).data('paciente-id');
            var row = $(this).closest('tr');
            var dataUrl = $(this).data('url');
            deactivatePatient(patientId, row, dataUrl);
        });

        $(".enable-btn-patient, .disable-btn-patient").removeClass('disabled').css('pointer-events', 'auto');
    }

    function checkIfTableIsEmpty() {
        var activeTable = $('#activePatientsTable tbody');
        var inactiveTable = $('#inactivePatientsTable tbody');

        if (activeTable.children('tr').length === 0) {
            $('#activePatientsTable').hide();
            $('#activePatientsTable').after('<div id="emptyActiveTableMessage">No hay datos disponibles por el momento.</div>');
        } else {
            $('#activePatientsTable').show();
            $('#emptyActiveTableMessage').remove();
        }

        if (inactiveTable.children('tr').length === 0) {
            $('#inactivePatientsTable').hide();
            $('#inactivePatientsTable').after('<div id="emptyInactiveTableMessage">No hay datos disponibles por el momento.</div>');
        } else {
            $('#inactivePatientsTable').show();
            $('#emptyInactiveTableMessage').remove();
        }
    }

    // Inicializar los eventos de clic para los botones existentes
    reassignEventsAndClasses();

    // Reasignar eventos después de cada redibujado de DataTables
    $('#activePatientsTable').on('draw.dt', function() {
        reassignEventsAndClasses();
    });

    $('#inactivePatientsTable').on('draw.dt', function() {
        reassignEventsAndClasses();
    });
});