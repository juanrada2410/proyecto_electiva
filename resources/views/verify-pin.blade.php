<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar PIN - Banco de Bogotá</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_banco_bogota.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-gray flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 m-4">
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo Banco de Bogotá" class="h-10 mx-auto mb-4">
            <h1 class="text-2xl font-bold text-banco-blue">Verificar Código de Acceso</h1>
            <p class="text-gray-600 mt-2">
                Hemos enviado un PIN de 6 dígitos a tu correo.
                @if(env('APP_DEBUG', false))
                    (Modo Debug: Revisa tu log en `storage/logs/laravel.log` para verlo al instante).
                @endif
            </p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <strong class="font-bold">Error:</strong>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.verifyPin') }}" method="POST">
            @csrf
            <div>
                <label for="pin" class="sr-only">PIN de 6 dígitos</label>
                <input type="tel" name="pin" id="pin" class="block w-full text-center text-3xl font-bold tracking-[0.5em] p-4 border-2 border-gray-300 rounded-lg focus:ring-banco-yellow focus:border-banco-yellow transition" maxlength="6" pattern="[0-9]{6}" required autofocus>
            </div>
            
            <button type="submit" class="w-full mt-6 bg-banco-yellow text-banco-blue font-bold py-3 rounded-lg hover:bg-yellow-400 transition-transform transform hover:scale-105">
                Verificar e Ingresar
            </button>
        </form>
    </div>
</body>
</html>