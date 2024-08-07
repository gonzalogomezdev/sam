<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario Médico</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .recetario {
            max-width: 100%;
            max-height: 90%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #0C6980;
            background-color: #ffffff;
            box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            height: 11.69in;
            position: relative;
        }
        .recetario h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        .recetario p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }
        .recetario .doctor-info {
            font-weight: bold;
        }
        .recetario .patient-info {
            font-style: italic;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 10px;
            font-weight: bold;
            color: #333;
            width: 40%;
            text-align: center;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            margin-bottom: 30px;
        }
        
        /* Estilos para la imagen */
        .image-container {
            margin-bottom: 20px; /* Añadido para separar la imagen del contenido */
        }
        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 5px; /* Añadido para dar bordes redondeados a la imagen */
        }
        .footer-container img {
            width: 100%;
            height: auto;
            border-radius: 5px; /* Añadido para dar bordes redondeados a la imagen */
        }
        .medicament{
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .tratamient{
            margin-top: 30px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container recetario">
        <div class="image-container">
           {{-- <img src="{{ asset('assets/images/encabezado.png') }}
">  --}}
        </div>
        <h1 class="text-center">Recetario Médico</h1>
        <hr>
        <p class="patient-info"><strong>Paciente:</strong> {{$paciente->Nombre}} {{$paciente->Apellido}}</p>
        <p class="patient-info"><strong>Fecha de atención médica:</strong> {{$historial->Fecha}}</p>
        <p class="patient-info"><strong>Fecha de PDF:</strong> {{$fechaPDF}}</p>
        <p class="medicament"><strong>Medicamentos:</strong> </p>
        <ul>
            <p>{{$historial->Medicamento}}</p>
        </ul>
        <p class="tratamient"><strong>Tratamiento:</strong></p>
        <ul>
          <p>{{$historial->Tratamiento}}</p>
        </ul>
        
        <hr>
        <div class="signature-line">Firma </div>
        <div class="footer-container">
          {{-- <img src="{{ asset('assets/images/footer.png') }}
"> --}}
        </div>
    </div>  
    
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>
</html>
