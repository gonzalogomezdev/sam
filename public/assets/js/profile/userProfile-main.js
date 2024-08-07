$(document).ready(function() {
    var userLocality = $('#select2lista').data('user-locality');

    cargarLocalidadUsuario(); // Cargar la localidad del usuario al abrir el modal
    
    // Event listener para el cambio en el select de provincias
    $('#lista1').change(function() {
        var provinciaId = $(this).val(); // Obtener el ID de la provincia seleccionada
        if (provinciaId) {
            obtenerLocalidades(provinciaId);
        } else {
            $('#select2lista').empty(); // Limpiar el select de localidades si no hay provincia seleccionada
            $('#select2lista').append('<option disabled="true" selected="true" value="0">Seleccione la localidad</option>');
        }
    });

    // Manejar el envío del formulario mediante AJAX
    $('#updateUserForm').submit(function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del formulario
        actualizarUsuario();
    });

    // Manejar el envío del formulario de cambio de contraseña mediante AJAX
    $('#changePasswordForm').submit(function(event) {
        event.preventDefault(); // Prevenir el comportamiento por defecto del formulario
        cambiarContraseña();
    });

    // Función para cargar la localidad del usuario al abrir el modal
    function cargarLocalidadUsuario() {
        $('#select2lista').val(userLocality); // Seleccionar la localidad del usuario en sesión
        // console.log('Valor de userLocality:', userLocality);
    }

    // Función para obtener localidades por provincia mediante AJAX
    function obtenerLocalidades(provinciaId) {
        $.ajax({
            type: "GET",
            url: "/obtener-localidades/" + provinciaId,
            success: function(data) {
                var select2lista = $('#select2lista');
                select2lista.empty(); // Limpiar el select de localidades
                select2lista.append('<option disabled="true" selected="true" value="0">Seleccione la localidad</option>');
                
                // Agregar las nuevas opciones de localidades
                $.each(data, function(key, value) {
                    select2lista.append('<option value="' + value.idLocalidad + '">' + value.Desc_Localidad + '</option>');
                });
                // Seleccionar automáticamente la primera localidad si hay opciones disponibles
                if (data.length > 0) {
                    select2lista.val(data[0].idLocalidad);
                } 
            }
        });
    }

    // Función para actualizar el usuario mediante AJAX
    function actualizarUsuario() {
        $.ajax({
            type: "POST",
            url: routes.updateProfile,
            data: $('#updateUserForm').serialize(),
            success: function(response) {
                if (response.success) {
                    $('#notificationContainer').html('<div class="alert alert-success">' + response.message + '</div>');
                    location.reload(); // Recargar la página para ver los cambios
                } else {
                    $('#notificationContainer').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            }
        });
    }

    // Función para cambiar la contraseña mediante AJAX
    function cambiarContraseña() {
        $.ajax({
            type: "POST",
            url: routes.updatePassword,
            data: $('#changePasswordForm').serialize(),
            success: function(response) {
                if (response.success) {
                    $('#passwordChangeNotificationContainer').html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(function() {
                        $('#passwordChangeNotificationContainer').empty(); // Limpiar el contenedor de notificaciones
                        $('#changePasswordForm')[0].reset(); // Limpiar el formulario de cambio de contraseña
                    }, 1000);
                } else {
                    $('#passwordChangeNotificationContainer').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function(response) {
                var errors = response.responseJSON.errors;
                var errorHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#passwordChangeNotificationContainer').html(errorHtml);
            }
        });
    }
});