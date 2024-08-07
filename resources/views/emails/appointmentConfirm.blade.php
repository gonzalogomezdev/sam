<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Turno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
        }

        p {
            margin-bottom: 20px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        li {
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmación de Turno</h1>
        <p>Hola <strong>{{ $patient->Nombre }}</strong>,</p>
        <p>Te escribimos para confirmar tu turno con el Dr. Fabio Cantero:</p>
        <ul>
            <li><strong>Fecha:</strong> {{ $date }}</li>
            <li><strong>Hora:</strong> {{ $time }}</li>
        </ul>
        <p>¡Nos vemos pronto!</p>
        <p><em>Equipo de Atención Médica</em></p>
    </div>
</body>
</html>
