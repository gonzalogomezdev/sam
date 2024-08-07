@extends('layouts.app')

@section('styles')
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/register/register.css') }}">
@endsection

@section('title', 'Registro')

@section('content')
<header>
    <div class="nav container-header">
        <a href="{{ route('home') }}">
        <img src="assets/images/logo_doctor.png" id="logo-doctor">
        </a>
        <h3 id="description-doctor">
        S.A.M - Dr. Fabio Cantero
        </h3>
    </div>
</header>

<section class="register container">
    <div class="row">
        <div class="col-lg-6 col-md-12 order-lg-2 d-none d-lg-block">
            <div class="box-image">
                <img src="assets/images/registro.png">
            </div>
        </div>

        <div class="col-lg-6 col-md-12 order-lg-1">
            <div class="box-form">
                <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <h2 id="title">Registrate</h2>
                    <p id="text">Al momento de registrarte, enviaras una solicitud al Doctor
                    para ser un paciente y obtener todos beneficios del
                    Sistema de Atención Médica
                    </p>
                    <strong class="line-decoration">Ingresar información de su cuenta</strong>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <label class="form-label">Apellido <span class="asterisk">*</span></label>
                    <input type="text" class="input-form" placeholder="Ingrese su apellido" name="Apellido" value="{{ old('Apellido') }}" required="">
                </div>
                <div class="mb-3">
                    <label class="form-label">Nombre <span class="asterisk">*</span></label>
                    <input type="text" class="input-form" placeholder="Ingrese su nombre" name="Nombre" value="{{ old('Nombre') }}" required="">
                </div>
                <div class="mb-3">
                    <label class="form-label">DNI <span class="asterisk">*</span></label>
                    <input type="text" class="input-form" placeholder="Ingrese su documento" name="DNI" value="{{ old('DNI') }}" required="">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mail <span class="asterisk">*</span></label>
                    <input type="email" class="input-form" placeholder="Ingrese su email" name="Email" value="{{ old('Email') }}" required="">

                    @if($errors->has('Email'))
                        <span class="text-danger passwordAlert">{{ $errors->first('Email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña <span class="asterisk">*</span></label>
                    <input type="password" class="input-form" placeholder="Ingrese su contraseña" name="Password" required="">

                    @if($errors->has('Password'))
                        <span class="text-danger passwordAlert">{{ $errors->first('Password') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña <span class="asterisk">*</span></label>
                    <input type="password" class="input-form" placeholder="Confirme su contraseña" name="passwordConfirmation" required="">

                    @if($errors->has('passwordConfirmation'))
                        <span class="text-danger passwordAlert">{{ $errors->first('passwordConfirmation') }}</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <input class="form-check-input" type="checkbox" id="terminos" required="">
                    <label class="form-check-label" for="terminos">
                        Acepto los términos y condiciones
                    </label>
                </div>

                <button type="submit" id="button-register">Registrarme</button>

                <div class="mb-3 log-in">
                    <label>¿Tienes una cuenta?</label> <a href="{{ route('login.form') }}"><span>Iniciar Sesión</span></a>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection