@extends('layouts.app')

@section('content')
<section class="messages container-messages">
    <div class="first-column"> 
        <!-- <div class="input-search">
            <i class="fas fa-search fa-sm"></i> 
            <input type="text" id="searchInput" placeholder="Buscar...">
        </div> -->

        <div class="list-users">
        @if ($professional)
            @foreach($usersWithMessages as $user)
                <ul>
                    <li>
                        <a class="messages-link" data-id="{{ $user->Usuarios_idUsuario }}" data-name="{{ $user->Nombre }}" data-url="{{ route('getConversation') }}">
                            <div class="user-img">
                                @if ($user->Generos_idGenero == 1)
                                <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile.svg') }}">
                                @elseif ($user->Generos_idGenero == 2)
                                <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile_3.svg') }}">
                                @endif
                            </div>

                            <div class="user-message">
                                <span>{{ $user->Apellido }} {{ $user->Nombre }}</span>
                                <br>
                                <p>{{ $user->userLastMessage }}</p>
                            </div>
                        </a>
                    </li>
                </ul> 
            @endforeach
        @elseif ($patient)
            @foreach($usersWithMessages as $user)
                <ul>
                    <li>
                        <a class="messages-link" data-id="{{ $user->Usuarios_idUsuario }}" data-name="{{ $user->Nombre }}" data-url="{{ route('getConversation') }}">
                            <div class="user-img">
                                @if ($user->Generos_idGenero == 1)
                                <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile.svg') }}">
                                @elseif ($user->Generos_idGenero == 2)
                                <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile_3.svg') }}">
                                @endif
                            </div>

                            <div class="user-message">
                                <span>{{ $user->Apellido }} {{ $user->Nombre }}</span>
                                <br>
                                <p>{{ $user->userLastMessage }}</p>
                            </div>
                        </a>
                    </li>
                </ul>
            @endforeach
        @endif
        </div>
    </div>

    <div class="second-column">
        <div class="header">
            
        </div>

        <!-- Chat -->
        <div class="messages" id="messages">

        </div>
        <!-- End Chat -->

        <!-- Footer -->
        <div class="bottom">
            <form id="messageForm">
                <textarea id="message" name="message" placeholder="Escribe un Mensaje..."></textarea>
                <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
        <!-- End Footer -->
    </div> 
</section>
@endsection

<script>
    // to do 
    // actualizar first column con los mensajes nuevos
    var idUser = {{ $idUser ? $idUser : 'null' }};
    var nameUser = @json($professional ? $professional->Nombre : ($patient ? $patient->Nombre : 'null'));
</script>

@section('scripts')
    <script src="{{ asset('assets/js/messaging/message-main.js') }}"></script>
@endsection