<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Banco de Bogotá</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-blue-900">Acceso al Sistema de Turnos</h1>
            <p class="text-gray-600 mt-2">Introduce tu documento para recibir un PIN de acceso en tu correo.</p>
        </div>
        
        <form method="POST" action="{{ route('login.sendPin') }}">
            @csrf
            <div class="mb-4">
                <label for="document_number" class="block text-sm font-medium text-gray-700">Número de Documento</label>
                <input type="text" id="document_number" name="document_number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required autofocus>
                @error('document_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-blue-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                    Enviar PIN
                </button>
            </div>
        </form>
    </div>
</body>
</html>