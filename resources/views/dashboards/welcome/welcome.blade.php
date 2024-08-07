<style>
    .chart-container {
    position: relative;
    height: 200px; 
    width: 100%; 
}

.small-chart-container {
    position: relative;
    height: 200px; 
    width: 100%;
}
</style>

<!-- Verifica si el usuario es profesional -->
@if (Session::has('Professional_' . Session('UserId')))
<div class="container-fluid">
    <div class="row">
        <!-- Turnos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Turnos del día
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['turnosDelDia'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pacientes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cantidad de Pacientes
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['patientCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historiales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Historiales Clínicos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['patientsWithConsultationsCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <!-- Consultas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Consultas Médicas
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['consultationsCount'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-7 col-lg-6">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Análisis de Turnos y su Variación Mensual</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                    <div class="container my-4">
                        <hr>
                        <p class="text-justify small">
                            Este diagrama de líneas muestra la cantidad de turnos registrados a lo largo de los meses del año. La visualización revela <span class="font-weight-bold">fluctuaciones en la demanda</span>, con <span class="font-weight-bold">picos en ciertos meses que indican alta demanda</span> y <span class="font-weight-bold">caídas en otros que sugieren menor actividad</span>. Analizar estas variaciones permite <span class="font-weight-bold">ajustar la planificación y los recursos</span> para <span class="font-weight-bold">optimizar la gestión de turnos</span> y responder de manera más efectiva a las <span class="font-weight-bold">tendencias estacionales</span>.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Análisis Mensual del Ingreso de Pacientes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="myBarChart"></canvas>
                    </div>
                    <div class="container my-4">
                        <hr>
                        <p class="text-justify small">
                            Este diagrama muestra la <span class="font-weight-bold">cantidad de pacientes ingresados cada mes</span> durante el año, destacando las <span class="font-weight-bold">fluctuaciones y patrones mensuales</span>. El análisis revela <span class="font-weight-bold">variaciones en el número de pacientes</span>, con <span class="font-weight-bold">picos y caídas en ciertos meses</span>, lo que permite <span class="font-weight-bold">ajustar recursos y estrategias</span> para gestionar el flujo de pacientes de manera más efectiva.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Médicas y Usuarios -->
        <div class="col-xl-5 col-lg-6">
            <!-- Donut Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribución de Estados de Tratamientos Médicos</h6>
                </div>
                <div class="card-body">
                    <div class="small-chart-container">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="container my-4">
                        <hr>
                        <p class="text-justify small">
                            Este diagrama presenta la distribución de tratamientos médicos según su estado actual, categorizados en términos de cantidad. Los estados considerados son <span class="font-weight-bold">No Concluido</span>, <span class="font-weight-bold">En Curso</span> y <span class="font-weight-bold">Concluido</span>. Este análisis ayuda a visualizar las fases de los tratamientos actuales e identificar el accionar de los pacientes en relación a los mismos.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cantidad de Usuarios Activos e Inactivos</h6>
                </div>
                <div class="card-body">
                    <!-- Add your users dashboard content here -->
                    <!-- You can add charts or other elements similar to the patients dashboard -->
                    <div class="chart-container">
                        <canvas id="myUserChart"></canvas>
                    </div>
                    <div class="container my-4">
                        <hr>
                        <p class="text-justify small">
                            Este diagrama muestra la <span class="font-weight-bold">cantidad de usuarios activos e inactivos</span>. La visualización resalta las <span class="font-weight-bold">diferencias significativas</span> entre ambas categorías. El análisis revela <span class="font-weight-bold">variaciones en la cantidad de usuarios</span>, lo que es esencial para <span class="font-weight-bold">ajustar estrategias de retención</span> y <span class="font-weight-bold">optimizar la gestión de usuarios</span>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphics -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var data = @json($data);

    var turnosPorMes = Object.values(data.turnosPorMes);
    var patientsRegisteredPerMonth = Object.values(data.patientsRegisteredPerMonth);
    var consultationsData = [
        data.consultationsInProgressCount,
        data.consultationsCompletedCount,
        data.consultationsNotCompletedCount
    ];
    var usersData = [data.activeUsers, data.inactiveUsers];

    // Gráfico de Área
    var ctxArea = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(ctxArea, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Cantidad de Turnos',
                data: turnosPorMes,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                fill: true,
                tension: 0.1,
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(...turnosPorMes) + 10
                }
            }
        }
    });

    // Gráfico de Barras
    var ctxBar = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            datasets: [{
                label: 'Cantidad de Pacientes',
                data: patientsRegisteredPerMonth,
                backgroundColor: 'rgba(78, 115, 223, 0.75)',
                borderColor: 'rgba(78, 115, 223, 1)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(...patientsRegisteredPerMonth) + 10
                }
            }
        }
    });

    // Gráfico de Dona
    var ctxPie = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['En Proceso', 'Completados', 'No Completados'],
            datasets: [{
                data: consultationsData,
                backgroundColor: ['#4e73df', '#1cc88a', '#e74a3b'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true
        }
    });

    // Gráfico de Usuarios
    var ctxUser = document.getElementById('myUserChart').getContext('2d');
    var myUserChart = new Chart(ctxUser, {
        type: 'bar',
        data: {
            labels: ['Usuarios Activos', 'Usuarios Inactivos'],
            datasets: [{
                label: 'Cantidad de Usuarios',
                data: usersData,
                backgroundColor: ['#4e73df', '#f6c23e'],
                borderColor: ['#4e73df', '#f6c23e'],
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(...usersData) + 10
                }
            }
        }
    });
</script>
@endif

<!-- Verifica si el usuario es paciente -->
@if (Session::has('Patient_' . Session('UserId')))
<div class="welcome-text">
    <h1 style="font-weight: 400;">
        Has ingresado al <br> 
        <span>Sistema</span> de <br> 
        <span>Atención Médica</span> 
    </h1>
    <h4 style="font-weight: 400;">BIENVENIDO: Paciente</h4>
    <p>
        Tendrás acceso a una amplia gama de herramientas para facilitar la gestión de usuarios, el calendario de turnos y la agenda, así como la administración del historial clínico. Estamos seguros de que esta plataforma te ayudará a optimizar su trabajo. <span>¡Explora y utiliza todas las funcionalidades, que de seguro brindará un excelente y honorable servicio de atención médica!</span>
    </p>
</div>
<div class="welcome-img">
    <img src="{{ asset('assets/images/welcome.png') }}">
</div>
@endif