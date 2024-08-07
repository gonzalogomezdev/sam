// var userIdChat, userNameChat, dataUrl;

$(document).ready(function() {
    console.log(pusher);

    $(document).off("click", ".messages-link").on("click", ".messages-link", function(e){
        e.preventDefault();

        document.getElementById('messageForm').reset();

        userIdChat = $(this).data('id');
        dataUrl = $(this).data('url');
        userNameChat = $(this).data('name');

        console.log("user chat "+userIdChat);

        getConversation(userIdChat, dataUrl);
    });

    function getConversation(userIdChat, dataUrl) {
        $.ajax({
            type: "GET", 
            url: dataUrl, 
            data: {
                id: userIdChat,
            },
            success: function(response) {
                document.querySelector('.second-column').style.display = 'block';

                var messagesContainer = document.getElementById("messageForm");
                messagesContainer.style.display = "flex";
                messagesContainer.style.alignItems = "center";

                $('.second-column .messages').empty();
                $('.second-column .header').empty();
                
                var element = document.querySelector('.header');
                element.style.borderBottom = '1px solid #dee2e6';

                var headerName = 
                '<h4>' + userNameChat + '</h4>' + 
                '<button id="closeChatButton">' + '<i class="fa-solid fa-xmark"></i>' + '</button>';
                $('.second-column .header').append(headerName);

                if(response.noMessages) {
                    $('.second-column .messages').append('<div class="noMessages">No hay mensajes disponibles</div>');
                } else {
                    response.conver.forEach(function(message) {
                        var hora = message.Fecha_Hora.substring(11, 16);
                        var alignmentClass = message.Remitente_id === idUser ? 'right' : 'left';

                        var messageHtml = 
                        '<div class="message ' + alignmentClass + '">' +
                            '<div class="meta ' + alignmentClass + '">' + hora + '</div>' +
                            '<div class="text ' + alignmentClass + '">' +
                                '<div class="bubble ' + alignmentClass + '">' + message.userName + '<br>' + message.Mensaje + '</div>' +
                            '</div>' +
                        '</div>';

                        $('.second-column .messages').append(messageHtml);
                    });
                    
                    // Desplazar la vista hacia el último mensaje
                    scrollToLastMessage();
                }
                
                // Mostrar la segunda columna y ocultar la primera en pantallas pequeñas
                if ($(window).width() <= 768) {
                    $('.first-column').hide();
                    $('.second-column').addClass('active').show();
                    // $('.second-column').show();
                }

                // Evento de clic para cerrar el chat
                document.getElementById('closeChatButton').addEventListener('click', function() {
                    if ($(window).width() <= 768) {
                        // Para pantallas pequeñas
                        $('.second-column').removeClass('active').hide();
                        $('.first-column').show();
                    } else {
                        // Para pantallas grandes
                        document.querySelector('.second-column').style.display = 'none';
                    }
                    
                    messagesContainer.style.display = "none";
                    // Limpiar contenido del chat
                    $('.second-column .messages').empty();
                    $('.second-column .header').empty();
                });
            },
            error: function(error) {
                alert("Error al cargar el chat.");
            }
        }); 
    }

    function scrollToLastMessage() {
        var messagesContainer = $('.second-column .messages');
        var lastMessage = messagesContainer.find('.message:last'); // busca el último elemento con la clase message dentro del contenedor
        if (lastMessage.length > 0) { // Significa que se encontró al menos un mensaje.
            messagesContainer.scrollTop(lastMessage.offset().top - messagesContainer.offset().top + messagesContainer.scrollTop());
        }
    }

    function sendMessage(messageData) {
        // Hacer una llamada AJAX para guardar el mensaje en la base de datos
        $.ajax({
            url: "/save-message",
            method: 'POST',
            data: messageData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        }).done(function (res) {
            console.log(res.success);
            document.getElementById('messageForm').reset();
            // Luego de guardar el mensaje en la base de datos, envia a través de Pusher
            $.ajax({
                url: "/broadcast",
                method: 'POST',
                headers: {
                    'X-Socket-Id': pusher.connection.socket_id // Agrega el socket_id de Pusher a los encabezados de la solicitud
                },
                data: messageData
            }).done(function (res) {
                console.log("Enviado por pusher!");
                enableMessageInput();
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.error("Error al enviar el mensaje a través de Pusher:", textStatus, errorThrown);
                enableMessageInput();
            });

        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("Error al guardar el mensaje:", textStatus, errorThrown);
            enableMessageInput();
        });
    }

    // Evento para enviar mensaje al presionar Enter
    $('#message').off('keydown').on('keydown', function(event) {
        var messageText = $("form #message").val();
        if (messageText === '' && (event.key === 'Enter' && !event.shiftKey)) {
            event.preventDefault();
            return;
        } else if (messageText != '' && (event.key === 'Enter' && !event.shiftKey)) {
            event.preventDefault();
            disableMessageInput();
            
            var token = $('meta[name="csrf-token"]').attr('content');

            var messageData = {
                _token: token,
                remitenteId: idUser,
                destinatarioId: userIdChat,
                issuer: nameUser,
                message: $("form #message").val(),
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            };

            sendMessage(messageData);
        }
    });

    // Evento para enviar mensaje al hacer clic en el botón de enviar
    $("form").off('submit').on('submit', function (event) {
        var messageText = $("form #message").val();
        if (messageText === '') {
            event.preventDefault();
            return;
        } else if (messageText != '') {
            event.preventDefault();
            disableMessageInput();

            var token = $('meta[name="csrf-token"]').attr('content');

            var messageData = {
                _token: token,
                remitenteId: idUser,
                destinatarioId: userIdChat,
                issuer: nameUser,
                message: $("form #message").val(),
                time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            };

            sendMessage(messageData);
        }
    });

    // Función para deshabilitar el formulario de mensajes
    function disableMessageInput() {
        $('form #message').prop('disabled', true);
        $('form button[type="submit"]').prop('disabled', true);
    }

    // Función para habilitar el formulario de mensajes
    function enableMessageInput() {
        $('form #message').prop('disabled', false);
        $('form button[type="submit"]').prop('disabled', false);
    }

    // Evento para ajustar la interfaz al cambiar el tamaño de la ventana
    $(window).resize(function() {
        if ($(window).width() > 768) {
            $('.first-column').show();
            $('.second-column').removeClass('active').show();
        } else {
            if ($('.second-column').hasClass('active')) {
                $('.first-column').hide();
            } else {
                $('.second-column').hide();
            }
        }
    });
});