var userIdChat, userNameChat, dataUrl;

let pusher; 

$(document).ready(function() {
    // Inicializar Pusher
    initializePusher();

    function initializePusher() {
        pusher = new Pusher('91fe1aa00bdd1f8418d8', {
            cluster: 'sa1'
        });
       
        subscribeToChatChannel();
        subscribeToNotificationChannel();
        subscribeToListUpdateChannel();
    }

    function subscribeToChatChannel() {
        var chatChannel = pusher.subscribe('chat-channel');
        chatChannel.bind('chat-event', handleChatEvent);
    }

    function subscribeToNotificationChannel() {
        var notiChannel = pusher.subscribe('notification-channel');
        notiChannel.bind('notification-event', handleNotificationEvent);
    }

    function subscribeToListUpdateChannel() {
        var listChannel = pusher.subscribe('list-update-channel');
        listChannel.bind('list-update-event', handleListUpdateEvent);
    }
    
    function handleChatEvent(data) {
        var noMessages = document.querySelector('.noMessages');
        var messageContainer = document.getElementById('messages');
        
        // Elimina el mensaje "No hay mensajes disponibles"
        if (noMessages) {
            noMessages.remove();
        }
        
        var newMessage = document.createElement('div');
        var hora = data.time;
        
        var alignmentClass = parseInt(data.idSender) === idUser ? 'right' : 'left';
        
        var messageHtml = 
        '<div class="message ' + alignmentClass + '">' +
            '<div class="meta ' + alignmentClass + '">' + hora + '</div>' +
            '<div class="text ' + alignmentClass + '">' +
                '<div class="bubble ' + alignmentClass + '">' + data.issuer + '<br>' + data.message + '</div>' +
            '</div>' +
        '</div>';
        
        newMessage.innerHTML = messageHtml;
        
        if ((parseInt(data.idSender) === idUser || parseInt(data.idAddressee) === idUser) && (userIdChat === parseInt(data.idSender) || userIdChat === parseInt(data.idAddressee))) {
            messageContainer.appendChild(newMessage);
            scrollToLastMessage();
        }
    }

    function scrollToLastMessage() {
        var messagesContainer = $('.second-column .messages');
        var lastMessage = messagesContainer.find('.message:last'); // busca el último elemento con la clase message dentro del contenedor
        if (lastMessage.length > 0) { // Significa que se encontró al menos un mensaje.
            messagesContainer.scrollTop(lastMessage.offset().top - messagesContainer.offset().top + messagesContainer.scrollTop());
        }
    }

    function handleNotificationEvent(data) {
        if (parseInt(data.idAddressee) === idUser) {
            showNotification(data.issuer);
        }
    }

    function showNotification(issuer) {
        Swal.fire({
            title: `¡Tienes un mensaje de ${issuer}!`,
            icon: 'info',
            position: 'top-end',
            showConfirmButton: true,
            timer: 5000,
            timerProgressBar: true,
            toast: true,
            customClass: {
                container: 'swal2-container',
                popup: 'swal2-popup',
                icon: 'swal2-icon',
                title: 'swal2-title',
                confirmButton: 'swal2-confirm',
            }
        });
    }

    function handleListUpdateEvent(data) {
        // Actualizar la lista de usuarios aquí para ambos participantes
        if (parseInt(data.idSender) === idUser || parseInt(data.idAddressee) === idUser) {
            updateListOfUsers(data.idSender, data.lastMessage);
            updateListOfUsers(data.idAddressee, data.lastMessage);

            if (parseInt(data.idAddressee) === idUser) {
                const messageElement = document.querySelector('.user-message p');
                if (messageElement) {
                    messageElement.classList.add('font-weight-bold');
                }
                
                setTimeout(function() {
                    messageElement.classList.remove('font-weight-bold');
                }, 5000);
            }
        }
    }

    function updateListOfUsers(userId, lastMessage) {
        const userElement = document.querySelector(`[data-id="${userId}"]`);
        if (userElement) {
            const messageElement = userElement.querySelector('.user-message p');
            if (messageElement) {
                messageElement.textContent = lastMessage;
            }
            // Mover el elemento al principio de la lista
            const listUsersContainer = document.querySelector('.list-users');
            listUsersContainer.prepend(userElement.closest('ul'));
        }
    }
});
