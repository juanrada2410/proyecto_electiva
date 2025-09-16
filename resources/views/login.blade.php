<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Banco de Bogotá</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-container { max-width: 400px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #1a202c; margin-bottom: 20px; }
        .form-input { width: 100%; padding: 12px; margin-top: 8px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 12px; background-color: #ef3340; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; margin-top: 20px; }
        .btn:hover { background-color: #d4222f; }
        .alert-success { padding: 10px; margin-bottom: 15px; background-color: #d4edda; color: #155724; border-radius: 4px; }
        .error-message { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-top: 15px; text-align: left; }
        .register-link { text-align: center; margin-top: 20px; }
        .register-link a { color: #ef3340; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <p>Introduce tu número de documento para recibir un PIN de acceso.</p>
        
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="document_number">Número de Documento</label>
                <input type="text" name="document_number" id="document_number" class="form-input" value="{{ old('document_number') }}" required autofocus>
            </div>

            @if($errors->any())
                <div class="error-message">
                    <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            <button type="submit" class="btn">Enviar PIN</button>
        </form>

        <div class="register-link">
            <p>¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>