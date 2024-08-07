<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            margin: 0px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Recuperación de Contraseña</h2>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
            <p>Aquí tienes tu contraseña temporal:</p>
            <p style="text-align: center; font-size: 20px; font-weight: bold; color: #007bff;">{{ $tempPassword }}</p>
            <p>Utiliza esta contraseña para iniciar sesión. Una vez dentro, podrás cambiar tu contraseña en la sección de configuración de tu perfil.</p>
            <p>Si no solicitaste restablecer tu contraseña, por favor ignora este correo o contacta con soporte.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Equipo de Atención Médica. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
