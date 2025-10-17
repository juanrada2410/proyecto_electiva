<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso y Registro - Banco de Bogotá</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-light-gray flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-4 m-4" x-data="{ tab: 'login' }">
        <div class="text-center mb-6">
            <img src="{{ asset('img/logo_banco_bogota.png') }}" alt="Logo Banco de Bogotá" class="h-10 mx-auto">
        </div>

        <div class="flex border-b">
            <button @click="tab = 'login'" :class="{'border-banco-blue text-banco-blue': tab === 'login', 'text-gray-500': tab !== 'login'}" class="flex-1 py-2 font-semibold border-b-2 transition">
                Iniciar Sesión
            </button>
            <button @click="tab = 'register'" :class="{'border-banco-blue text-banco-blue': tab === 'register', 'text-gray-500': tab !== 'register'}" class="flex-1 py-2 font-semibold border-b-2 transition">
                Registrarse
            </button>
        </div>

        <div x-show="tab === 'login'" class="p-6">
             <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="document_number" class="block text-sm font-medium text-gray-700">Número de Documento</label>
                    <input type="text" name="document_number" id="document_number" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-banco-yellow focus:border-banco-yellow" required>
                    
                    {{-- LÍNEA CLAVE AÑADIDA PARA MOSTRAR EL ERROR --}}
                    @error('document_number')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                </div>
                <button type="submit" class="w-full bg-banco-yellow text-banco-blue font-bold py-3 rounded-lg hover:bg-yellow-400 transition">
                    Enviar PIN de Acceso
                </button>
            </form>
        </div>

        <div x-show="tab === 'register'" x-cloak class="p-6">
            {{-- Aquí va tu formulario de registro, asegúrate de que también tenga la directiva @error para cada campo --}}
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                 <div>
                    <label for="document_number">Número de Documento</label>
                    <input type="text" name="document_number" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm" required>
                    @error('document_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full bg-banco-blue text-white font-bold py-3 rounded-lg hover:bg-opacity-90 transition">
                    Crear Cuenta
                </button>
            </form>
        </div>
    </div>
</body>
</html>