<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Banco de Bogotá</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Figtree', sans-serif; background-color: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px 0; }
        .register-container { width: 100%; max-width: 450px; padding: 30px; background-color: white; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #1a202c; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-input { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc; box-sizing: border-box; }
        .btn { display: block; width: 100%; padding: 12px; background-color: #ef3340; color: white; border-radius: 4px; text-decoration: none; font-weight: bold; border: none; cursor: pointer; margin-top: 20px; }
        .btn:hover { background-color: #d4222f; }
        .error-message { color: #e3342f; font-size: 0.875rem; margin-top: 0.25rem; }
        .login-link { text-align: center; margin-top: 20px; }
        .login-link a { color: #ef3340; text-decoration: none; }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Crear una Cuenta</h1>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nombre Completo</label>
                <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" required>
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="document_number" class="form-label">Número de Documento</label>
                <input type="text" name="document_number" id="document_number" class="form-input" value="{{ old('document_number') }}" required>
                @error('document_number') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" required>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Teléfono (Opcional)</label>
                <input type="tel" name="phone" id="phone" class="form-input" value="{{ old('phone') }}">
                @error('phone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn">Registrarse</button>
        </form>

        <div class="login-link">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
        </div>
    </div>
</body>
</html>