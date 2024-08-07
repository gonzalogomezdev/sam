$(document).ready(function() {
    var isInMessagesSection = false;

    // Función para mostrar el loader
    function showLoader() {
        $('#loader').show();
    }

    // Función para ocultar el loader
    function hideLoader() {
        $('#loader').hide();
    }

    // Función para mostrar el mensaje de error
    function showError() {
    $('#error-message').addClass('show');
        setTimeout(function() {
            $('#error-message').removeClass('show');
        }, 5000); // El mensaje de error desaparece después de 5 segundos
    }

    function hideAllSections() {
        $("#welcome, #requestsContent, #calendarContent, #messageContent, #userProfileContent, #medicalHistory, #medicalRecord, #historyContent, #patientsContent, #socialWorkContent").hide();
    }

    function loadWelcome(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#welcome").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                console.error("Detalles del error:", xhr.responseText);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadRequests(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#requestsContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadCalendar(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#calendarContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadMessages(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#messageContent").html(data).show();
                isInMessagesSection = true;
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadMedicalHistory(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#medicalHistory").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadProfile(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#userProfileContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadMedicalRecord(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#medicalRecord").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadHistoryAppointments(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#historyContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadPatients(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#patientsContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function loadSocialWork(route) {
        showLoader();
        $.ajax({
            url: route,
            method: "GET",
            success: function(data) {
                $("#socialWorkContent").html(data).show();
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                showError();
            },
            complete: function() {
                hideLoader();
            }
        });
    }

    function unsubscribePusher(){
        if (pusher) {
            // Redirigir después de un retraso
            pusher.unsubscribe('chat-channel');
            console.log('Suscripciones activas después de desuscribirse:', pusher.channels.channels);
            console.log('Se ha desuscripto de Pusher.');
        }
    }

    $("#loadWelcome").on("click", function(e) {
        e.preventDefault();

        hideAllSections();
        
        var route = $(this).data('route');
        loadWelcome(route);
    });

    $("#loadRequests").on("click", function(e) {
        e.preventDefault();

        hideAllSections();
       
        var route = $(this).data('route');
        loadRequests(route);
    });

    $("#loadCalendar").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadCalendar(route);
    });
    
    $("#loadMessages").on("click", function(e) {
        e.preventDefault();

        if (isInMessagesSection) {
            hideAllSections();
            $("#messageContent").show();    
            console.log(isInMessagesSection);
        } else {
            hideAllSections();
            var route = $(this).data('route');
            loadMessages(route);
        }
    });

    $("#logoutButton").on("click", function(e) {
        e.preventDefault();
        unsubscribePusher();

        // Esperar un momento antes de redirigir para asegurarse de que la desuscripción se haya procesado
        setTimeout(function() {
            window.location.href = $("#logoutButton").attr('href');
        }, 500);
    });

    $("#loadProfile").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadProfile(route);
    });

    $("#loadMedicalHistory").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadMedicalHistory(route);
    });

    $("#loadMedicalRecord").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadMedicalRecord(route);
    });

    $("#loadHistory").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadHistoryAppointments(route);
    });

    $("#loadPatients").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadPatients(route);
    });

    $("#loadSocial").on("click", function(e) {
        e.preventDefault();

        hideAllSections();

        var route = $(this).data('route');
        loadSocialWork(route);
    });
});
