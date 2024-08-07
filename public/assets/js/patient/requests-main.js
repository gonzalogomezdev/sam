$(document).ready(function() {
    function acceptUserRequest(id, row, dataUrl) {
        $(".alta-btn-request, .baja-btn-request").addClass('disabled').css('pointer-events', 'none');
        $.ajax({
            type: "POST",
            url: dataUrl,
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('El paciente ha sido dado de alta!');
                if (window.dataTable) {
                    window.dataTable.row(row).remove().draw(false);
                }
                checkIfTableIsEmpty();
            },
            error: function(error) {
                alert("Error al dar de alta al paciente.");
                $(".alta-btn-request, .baja-btn-request").removeClass('disabled').css('pointer-events', 'auto');
            },
            complete: function() {
                $(".alta-btn-request, .baja-btn-request").removeClass('disabled').css('pointer-events', 'auto');
            }
        });
    }

    function RejectUserRequest(row, dataUrl) {
        $(".alta-btn-request, .baja-btn-request").addClass('disabled').css('pointer-events', 'none');
        $.ajax({
            type: "DELETE",
            url: dataUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('El paciente ha sido dado de baja!');
                if (window.dataTable) {
                    window.dataTable.row(row).remove().draw(false);
                }
                checkIfTableIsEmpty();
            },
            error: function(error) {
                alert("Error al dar de baja al paciente.");
                $(".alta-btn-request, .baja-btn-request").removeClass('disabled').css('pointer-events', 'auto');
            },
            complete: function() {
                $(".alta-btn-request, .baja-btn-request").removeClass('disabled').css('pointer-events', 'auto');
            }
        });
    }

    function checkIfTableIsEmpty() {
        if (window.dataTable && window.dataTable.data().count() === 0) {
            $('#requestsTable').hide();  // Oculta la tabla
            $('.dataTables_wrapper').hide(); // Oculta el contenedor de DataTables
            $('#emptyTable').show(); // Muestra el mensaje de tabla vacía
        } else {
            $('#requestsTable').show();  // Muestra la tabla si hay datos
            $('.dataTables_wrapper').show(); // Muestra el contenedor de DataTables
            $('#emptyTable').hide(); // Oculta el mensaje de tabla vacía
        }
    }   

    // Delegación de eventos
    $('#requestsTable').on('click', '.alta-btn-request', function(e){
        e.preventDefault();

        var patientId = $(this).data('paciente-id');
        var row = $(this).closest('tr');
        var dataUrl = $(this).data('url');

        acceptUserRequest(patientId, row, dataUrl);
    });

    $('#requestsTable').on('click', '.baja-btn-request', function(e){
        e.preventDefault();

        var row = $(this).closest('tr');
        var dataUrl = $(this).data('url');

        RejectUserRequest(row, dataUrl);
    });
});