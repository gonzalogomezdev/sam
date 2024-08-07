@extends('layouts.app')

@section('styles')
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/login/login.css') }}">
@endsection

@section('title', 'Iniciar Sesión')

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

<section class="login container">
  <div class="row">
    <div class="col-lg-6 col-md-12 order-lg-2 d-none d-lg-block">
      <div class="box-image">
        <img src="{{ asset('assets/images/login_doctor.png') }}" alt="Login Doctor">
      </div>
    </div>

    <div class="col-lg-6 col-md-12 order-lg-1">
      <div class="box-form">
        <form action="{{ route('login.form') }}" method="POST">
          @csrf
          <div class="mb-3">
            <h2 id="title">Bienvenido!</h2>
            @if(session('inProgress'))
              <div class="alert alert-warning">{{ session('inProgress') }}</div>
            @endif

            @if(session('errorUser'))
              <div class="alert alert-danger">{{ session('errorUser') }}</div>
            @endif

            @if(session('errorData'))
              <div class="alert alert-danger">{{ session('errorData') }}</div>
            @endif

            @if(session('reject'))
              <div class="alert alert-danger">{{ session('reject') }}</div>
            @endif

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <p>Por favor ingresa tus credenciales para
            ingresar <br> al Sistema de Atención Médica.</p>
            <label class="form-label">E-mail</label>
            <input type="email" class="form-control" placeholder="Ingrese su email" id="input-email" name="Email">
            <div id="emailHelp" class="form-text">
              Nunca compartiremos su correo electrónico con nadie más.
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" placeholder="Ingrese su contraseña" id="input-password" name="Password">
          </div>
          <div class="mb-3" id="recover-password">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-recover-password">Recuperar Contraseña</a>
          </div>
          <button type="submit" id="log-in">Iniciar Sesión</button>
          <div class="mb-3" id="new-account">
            <label>¿No tienes una cuenta?</label> <a href="{{ route('register.form') }}">Registrate</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="modal-recover-password" tabindex="-1" aria-labelledby="modal-recover-passwordLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close align-self-end" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        <div class="d-flex justify-content-center">
          <img src="assets/images/logo_doctor.png" id="logo-doctor-modal">
        </div>
        <h5 class="modal-title text-center" id="modal-recover-passwordLabel">Recuperar Contraseña</h5>
      </div>

      <div class="modal-body">
        <form action="{{ route('sendPasswordResetLink') }}" method="POST">
          @csrf 
          <div class="mb-3">
            <p>Ingrese su correo electrónico para recuperar su contraseña:</p>
            <input type="email" class="form-control" id="emailRecover" name="email" placeholder="Ingrese su correo electrónico">
          </div>
          <button type="submit" id="button-recover">Enviar</button>
          <p id="text-recover">Recibirá un correo electrónico con la informacón necesaria para 
            <span id="text-access">
            recuperar su acceso al sistema.
            </span>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection