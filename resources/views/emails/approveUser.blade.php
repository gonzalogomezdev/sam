<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Aprobada</title>
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
            color: #007bff;
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
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cuenta Aprobada</h1>
        </div>
        <div class="content">
            <p>Querido/a {{ $patient->Nombre }},</p>
            <p>Nos complace informarle de que su cuenta ha sido aprobada. Ya puede acceder a todas las funcionalidades de nuestro sistema.</p>
            <p>Gracias por unirse!</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Equipo de Atención Médica. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
