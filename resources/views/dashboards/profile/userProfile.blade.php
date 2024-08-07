@extends('layouts.app')

@section('content')
<header>
    <div class="nav container-header">
        <div>
            <h3>Mis Datos</h3>
        </div>
    </div>
</header>

<section class="userProfile container">
    <div class="userProfile-content">
        <div>
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <h3>{{ $user->Apellido ?? '-' }} {{ $user->Nombre ?? '-' }}</h3>
        </div>
        <div>
            <strong>{{ $user->Edad ?? '-' }} años</strong>
        </div>
        <div>
            <strong>Argentina, {{ $user->city->Desc_Localidad ?? '-' }} - {{ $user->city->province->Desc_Prov ?? '-' }}</strong>
        </div>
    </div>
    <div class="userProfile-options">
        <div class="option">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-update-profile">
                <i class="fa-solid fa-pen"></i> Personalizar
            </a>
        </div>
    </div>
</section>

<section class="formUpdate container">
    <div class="formUpdate-modal">
        <div class="modal fade userProfile" id="modal-update-profile" tabindex="-1" aria-labelledby="modal-update-profile-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-update-profile-label">Actualizar Información</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-update-data-tab" data-bs-toggle="tab" data-bs-target="#tab-update-data" type="button" role="tab" aria-controls="tab-update-data" aria-selected="true">Actualizar Datos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-change-password-tab" data-bs-toggle="tab" data-bs-target="#tab-change-password" type="button" role="tab" aria-controls="tab-change-password" aria-selected="false">Cambiar Contraseña</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Tab para actualizar datos -->
                            <div class="tab-pane fade show active" id="tab-update-data" role="tabpanel" aria-labelledby="tab-update-data-tab">
                                <form id="updateUserForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label>Apellido</label>
                                        <input type="text" name="apellido" class="form-control" value="{{ $user->Apellido ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Nombre</label>
                                        <input type="text" name="nombre" class="form-control" value="{{ $user->Nombre ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="text" name="email" class="form-control" value="{{ $user->user->Email ?? '-' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label>DNI</label>
                                        <input type="text" name="dni" class="form-control" value="{{ $user->DNI ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Género</label>
                                        <select name="genero" class="form-select">
                                            <option disabled selected value="0">Seleccione el género</option>
                                            @foreach($genders as $gender)
                                                <option value="{{ $gender->idGenero }}" @if($user->Generos_idGenero == $gender->idGenero) selected @endif>
                                                    {{ $gender->Desc_Genero }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Telefono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ $user->Telefono ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Fecha de Nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $user->Fecha_Nacimiento ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Domicilio</label>
                                        <input type="text" name="domicilio" class="form-control" value="{{ $user->Domicilio ?? '-' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label>Estado Civil</label>
                                        <select name="estado_civil" class="form-select">
                                            <option disabled selected value="0">
                                                Seleccione el estado civil
                                            </option>
                                            @foreach($civilStates as $civilState)
                                                <option value="{{ $civilState->idEstado_Civil }}" @if($user->Estados_Civiles_idEstado_Civil == $civilState->idEstado_Civil) selected @endif>
                                                    {{ $civilState->Desc_Estado }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Provincia</label>
                                        <select id="lista1" class="form-select">
                                            <option disabled selected value="0">Seleccione la provincia</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->idProvincia }}" 
                                                    @if($user->city->province->idProvincia == $province->idProvincia) selected @endif>
                                                    {{ $province->Desc_Prov }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Localidad</label>
                                        <select id="select2lista" name="localidadProvincia" class="form-select" data-user-locality="{{ $user->city->idLocalidad }}">
                                            <option disabled selected value="0">Seleccione la localidad</option>
                                            @foreach($localities as $locality)
                                                <option value="{{ $locality->idLocalidad }}"
                                                    @if($user->city->idLocalidad == $locality->idLocalidad) selected @endif>
                                                    {{ $locality->Desc_Localidad }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary updateProfile">Actualizar</button>
                                </form>
                                <br>
                                <div id="notificationContainer"></div>
                            </div>
                            
                            <!-- Tab para cambiar contraseña -->
                            <div class="tab-pane fade" id="tab-change-password" role="tabpanel" aria-labelledby="tab-change-password-tab">
                                <div id="passwordChangeNotificationContainer"></div>
                                <form id="changePasswordForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label>Contraseña Nueva</label>
                                        <input type="password" name="new_password" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Confirmar Contraseña</label>
                                        <input type="password" name="confirm_password" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    var routes = {
        updateProfile: "{{ route('updateProfile') }}",
        updatePassword: "{{ route('updatePassword') }}"
    };
</script>
<script src="{{ asset('assets/js/profile/userProfile-main.js') }}"></script>
@endsection