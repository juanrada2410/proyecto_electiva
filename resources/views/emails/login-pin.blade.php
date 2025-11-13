<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu PIN de Acceso</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { font-size: 24px; color: #333; }
        .pin-code {
            font-size: 36px;
            font-weight: bold;
            color: #004a99; /* Color azul banco */
            text-align: center;
            letter-spacing: 5px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer { font-size: 12px; color: #888; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Hola,
        </div>
        <p>Has solicitado iniciar sesión en el Sistema de Turnos. Usa el siguiente PIN para completar tu acceso.</p>
        <p><strong>Este PIN es válido por 3 minutos.</strong></p>

        <div class="pin-code">
            {{ $pin }}
        </div>

        <p>Si no solicitaste este PIN, puedes ignorar este correo de forma segura.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Sistema de Turnos. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>