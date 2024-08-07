<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Rechazada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .header h1 {
            margin: 0;
            color: #d9534f;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin: 20px 0;
            font-size: 0.9em;
            color: #999;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #d9534f;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cuenta Rechazada</h1>
        </div>
        <div class="content">
            <p>Estimado/a {{ $patient->Nombre }},</p>
            <p>Lamentamos informarle que su solicitud de cuenta ha sido rechazada.</p>
            <p>Le agradecemos sinceramente por su interés.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Equipo de Atención Médica. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
