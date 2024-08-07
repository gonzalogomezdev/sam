@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
    @include('layouts.styles')
@endsection

@section('content')

<!-- Loader -->
<div id="loader" class="loader">
    <div class="spinner"></div>
</div>

<!-- Error -->
<div id="error-message" class="error-message">
  <p>Lo sentimos, no se pudo cargar la sección. Por favor, inténtelo de nuevo.</p>
</div>

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <!-- <i class="fas fa-laugh-wink"></i> -->
                <img src="assets/images/logo_doctor.png" id="logo-doctor">
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" id="loadWelcome" data-route="{{ route('welcome') }}">
                <i class="fa-solid fa-house"></i>
                <span>Inicio</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Herramientas
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        @if ($professional)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Gestión de Turnos</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadCalendar" data-route="{{ route('showCalendar') }}">Calendario</a>    
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadHistory" data-route="{{ route('appointments') }}">Historial</a>    
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa-solid fa-users"></i>
                <span>Gestión de Pacientes</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadRequests" data-route="{{ route('patientRequests') }}">Solicitudes</a>    
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadPatients" data-route="{{ route('patients') }}">Pacientes</a>    
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadSocial" data-route="{{ route('social') }}">Social</a>    
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fa-solid fa-heart-pulse"></i>
                <span>Atención Médica</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadMedicalHistory" data-route="{{ route('medicalHistory') }}">Historiales Clínicos </a> 
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                    <a class="collapse-item" id="loadMedicalRecord" data-route="{{ route('medicalRecord') }}">Registro de Consulta</a>    
                </div>
            </div>
        </li>

        @elseif ($patient)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fa-solid fa-calendar-days"></i>
                <span>Turnos</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="loadCalendar" data-route="{{ route('showCalendar') }}">Calendario</a>    
                </div>
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" id="loadHistory" data-route="{{ route('appointments') }}">Mis turnos</a>    
                </div>
            </div>
        </li>
        @endif

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i> 
                </button>
                <!-- Topbar Search -->
                <!-- <form
                    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i> Buscar
                            </button>
                        </div>
                    </div>
                </form> -->

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">                
                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="loadMessages" data-route="{{ route('showMessages') }}">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span class="badge badge-danger badge-counter">+1</span>
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if ($professional)
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                Dr. {{ $professional->Nombre }} {{ $professional->Apellido }}
                            </span>
                            <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile.svg') }}">
                            @elseif ($patient)
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ $patient->Nombre }} {{ $patient->Apellido }}
                            </span>
                            <img class="img-profile rounded-circle" src="{{ asset('assets/images/dashboard/undraw_profile.svg') }}">
                            @endif
                        </a>
                        
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" id="loadProfile" data-route="{{ route('myProfile') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Perfil
                            </a>
                            <!-- <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Cerrar Sesión
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="sections">
                <section id="welcome" class=" {{ Session::has('Patient_' . Session('UserId')) ? 'welcome container' : '' }}">
                    @include('dashboards.welcome.welcome', $data)
                </section>

                <section class="patient-requests">
                    <div id="requestsContent"></div>
                </section>

                <section class="calendar">
                    <div id="calendarContent"></div>
                </section>

                <section class="messages">
                    <div id="messageContent"></div>
                </section>

                <section class="profile">
                    <div id="userProfileContent"></div>
                </section>

                <section class="medicalRecord container">
                    <div id="medicalRecord"></div>
                </section>

                <section class="medicalHistory container">
                    <div id="medicalHistory"></div>
                </section>

                <section class="history">
                    <div id="historyContent"></div>
                </section>

                <section class="patients">
                    <div id="patientsContent"></div>
                </section>

                <section class="socialWork">
                    <div id="socialWorkContent"></div>
                </section>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Developed By Team Project</span>
                </div>
            </div>
        </footer>
    </div>
</div>

<!-- Scroll to Top Button-->
<!-- <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a> -->

<!-- Logout Modal-->
<div class="modal fade dashboard-modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Estás seguro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Seleccione "Salir" a continuación si desea finalizar la sesión actual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{ route('logout') }}" id="logoutButton">Salir</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var idUser = {{ $idUser ? $idUser : 'null' }};
        var nameUser = @json($professional ? $professional->Nombre : ($patient ? $patient->Nombre : 'null'));
        // console.log(idUser);

        $(document).ready(function() {
            $('.collapse-item').on('click', function() {
                var parentCollapse = $(this).closest('.collapse');
                parentCollapse.removeClass('show');
            });
        });
    </script>
    <!-- Dashboard -->
    <script src="{{ asset('assets/vendor-dashboard/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/sb-admin-2.min.js') }}"></script>
    <!-- Main Js -->
    <script src="{{ asset('assets/js/dashboard/dashboard-main.js') }}"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Pusher -->       
    <script src="{{ asset('assets/js/pusher.js') }}"></script>
    <!-- Alerts Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection