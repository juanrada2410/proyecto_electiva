<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar PIN - Banco de Bogotá</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { max-width: 400px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #1a202c; margin-bottom: 20px; }
        .form-input { width: 100%; padding: 12px; margin-top: 8px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; text-align: center; font-size: 1.5em; letter-spacing: 1em; }
        .btn { display: block; width: 100%; padding: 12px; background-color: #ef3340; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; margin-top: 20px; }
        .btn:hover { background-color: #d4222f; }
        .error-message { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-top: 15px; text-align: left; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Verificar Código de Acceso</h1>
        <p>Hemos enviado un PIN a tu correo. Revisa tu log (`storage/logs/laravel.log`) para obtenerlo.</p>

        <form action="{{ route('verify-pin') }}" method="POST">
            @csrf

            <div>
                <label for="pin">PIN de 4 dígitos</label>
                <input type="tel" name="pin" id="pin" class="form-input" maxlength="4" pattern="[0-9]{4}" required autofocus>
            </div>

            @if($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit" class="btn">Verificar e Ingresar</button>
        </form>
    </div>
</body>
</html>